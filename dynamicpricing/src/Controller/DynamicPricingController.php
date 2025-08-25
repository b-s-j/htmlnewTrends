<?php

namespace Drupal\dynamic_pricing\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Extension\ModuleExtensionList;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Controller for the Dynamic Pricing page.
 */
class DynamicPricingController extends ControllerBase {

  /**
   * @var \Drupal\Core\Extension\ModuleExtensionList
   */
  protected $moduleExtensionList;

  /**
   * Constructs a DynamicPricingController object.
   */
  public function __construct(ModuleExtensionList $module_extension_list) {
    // Inject the service to properly locate module files.
    $this->moduleExtensionList = $module_extension_list;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('extension.list.module')
    );
  }

  /**
   * Reads the sdge-data.json file from the module root.
   *
   * @return array
   * The pricing data array, or an empty array on failure.
   */
  private function loadPricingData() {
    // Kukunin ang path ng module folder.
    $module_path = $this->moduleExtensionList->getPath('dynamic_pricing');
    $file_path = DRUPAL_ROOT . '/' . $module_path . '/dynamic-data.json';
    
    // I-check kung nag-eexist ang file.
    if (!file_exists($file_path)) {
      $this->messenger()->addError('ERROR: Pricing data file (dynamic-data.json) not found.');
      return [];
    }

    // Basahin at i-decode ang JSON.
    $json_content = file_get_contents($file_path);
    $data = json_decode($json_content, TRUE);

    return $data['fdata'] ?? [];
  }

  /**
   * Builds the pricing table page.
   */
  public function build() {
    $data = $this->loadPricingData();
    $today_data = [];
    $tomorrow_data = [];

    if (!empty($data)) {
        // Kukunin ang date ng unang record para maging basehan ng "Today".
        $first_date = $data[0]['date'];
        
        // Paghihiwalay ng data sa Today at Tomorrow
        foreach ($data as $item) {
            if ($item['date'] === $first_date) {
                $today_data[] = $item;
            } else {
                $tomorrow_data[] = $item;
            }
        }
    }
    
    // Ang render array na ipapasa sa Twig.
    return [
      '#theme' => 'dynamic_pricing_table',
      '#today_data' => $today_data,
      '#tomorrow_data' => $tomorrow_data,
      '#today_date_display' => $today_data[0]['date'] ?? date('Y-m-d'),
      '#tomorrow_date_display' => $tomorrow_data[0]['date'] ?? date('Y-m-d', strtotime('+1 day')),
      // I-attach ang library na naglalaman ng styles/dependencies.
      '#attached' => [
        'library' => [
          'dynamic_pricing/dynamic-pricing-styles',
        ],
      ],
    ];
  }
}