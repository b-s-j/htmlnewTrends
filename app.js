document
  .getElementById("mode-switch")
  .addEventListener(
    "change",
    (e) =>
      (document.body.className = e.target.checked ? "dark-mode" : "light-mode")
  );

function createCircle(radius) {
  return {
    radius,
    draw: function () {
      console.log("draw");
    },
  };
}

const circle = createCircle(2);
console.log(circle);
