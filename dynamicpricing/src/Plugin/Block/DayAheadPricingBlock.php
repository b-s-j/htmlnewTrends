<?php

namespace Drupal\dynamic_pricing\Plugin\Block;


use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface; 


/**
 * Provides a 'Day Ahead Pricing' Block.
 *
 * @Block(
 *   id = "day_ahead_pricing_block",
 *   admin_label = @Translation("Day Ahead Pricing Block"),
 * )
 */

class DayAheadPricingBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#markup' => $this->t('Day Ahead Pricing Block content goes here.'),
    ];
  }

}
