window.onload = function () {
  var overlay = document.createElement('div');
  overlay.style.position = 'fixed';
  overlay.style.top = '0';
  overlay.style.left = '0';
  overlay.style.width = '100%';
  overlay.style.height = '100%';
  overlay.style.backgroundColor = 'white';
  overlay.style.opacity = '1';
  overlay.style.transition = 'opacity 1s';
  document.body.appendChild(overlay);

  var textContainer = document.createElement('div');
  textContainer.id = 'text-container';
  textContainer.style.opacity = '0';
  textContainer.style.transition = 'opacity 1s';
  document.body.appendChild(textContainer);

  fetch('https://yiyan.wlanu.com/?encode=text')
    .then(function (response) {
      return response.text();
    })
    .then(function (data) {
      textContainer.innerText = data;
      textContainer.style.color = '#989898';
      textContainer.style.opacity = '1';
    });

  setTimeout(function () {
    overlay.style.opacity = '0';
    textContainer.style.opacity = '0';

    setTimeout(function () {
      document.body.removeChild(overlay);
      document.body.removeChild(textContainer);
    }, 1000);
  }, 3000);
};
