document
  .getElementById("mode-switch")
  .addEventListener(
    "change",
    (e) =>
      (document.body.className = e.target.checked ? "dark-mode" : "light-mode")
  );

const circle = {
  radius: 1,
  location: {
    x: 1,
    y: 1,
  },
  draw: function () {
    console.log("draw");
  },
};

circle.draw();
