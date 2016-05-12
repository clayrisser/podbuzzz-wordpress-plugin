var homeUrl = getHomeUrl();

function updateKey() {
  var request = new XMLHttpRequest();
  var key = document.getElementById('keyInput').value;
  request.open('POST', homeUrl + '/podbuzzz_api/key?key=' + key, true);
  request.onload = function () {
    if (request.status >= 200 && request.status < 400) { // Success!
      var resp = JSON.parse(request.responseText);
      document.getElementById('statusMessage').innerHTML = resp.message;
      if (resp.success) { // Key successfully updated
        getKey();
        scriptInstalled();
      }
    } else { // We reached our target server, but it returned an error
      var error = 'PodBuzzz API returned an error.';
      document.getElementById('statusMessage').innerHTML = error;
      console.warn(error);
    }
  };
  request.onerror = function () { // There was a connection error of some sort
    var error = 'Could not connect to PodBuzzz API.';
    document.getElementById('statusMessage').innerHTML = error;
    console.warn(error);
  };
  request.send();
}

function getKey() {
  var request = new XMLHttpRequest();
  request.open('GET', homeUrl + '/podbuzzz_api/key', true);
  request.onload = function () {
    if (request.status >= 200 && request.status < 400) { // Success!
      var resp = JSON.parse(request.responseText);
      document.getElementById('currentKey').value = resp.message;
      if (resp.success) {
        document.getElementById('submitButton').innerHTML = 'Reinstall My Widget';
      }
    } else { // We reached our target server, but it returned an error
      var error = 'Connection Failed';
      document.getElementById('currentKey').innerHTML = error;
      console.warn(error);
    }
  };
  request.onerror = function () { // There was a connection error of some sort
    var error = 'Connection Failed';
    document.getElementById('currentKey').innerHTML = error;
    console.warn(error);
  };
  request.send();
}

function scriptInstalled() {
  var request = new XMLHttpRequest();
  request.open('GET', homeUrl + '/podbuzzz_api/scriptInstalled', true);
  request.onload = function () {
    if (request.status >= 200 && request.status < 400) { // Success!
      var resp = JSON.parse(request.responseText);
      document.getElementById('scriptInstalled').innerHTML = resp.message;
      if (resp.success) { // Key found
        document.getElementById('scriptInstalled').style.background = 'lightgreen';
      } else {
        document.getElementById('scriptInstalled').style.background = 'lightsalmon';
      }
    } else { // We reached our target server, but it returned an error
      var error = 'PodBuzzz API returned an error.';
      document.getElementById('scriptInstalled').innerHTML = error;
      console.warn(error);
    }
  };
  request.onerror = function () { // There was a connection error of some sort
    var error = 'Could not connect to PodBuzzz API.';
    document.getElementById('scriptInstalled').innerHTML = error;
    console.warn(error);
  };
  request.send();
}

function enableScript() {
  var enable = document.getElementById('podbuzzzScriptEnabled').checked;
  var request = new XMLHttpRequest();
  request.open('POST', homeUrl + '/podbuzzz_api/enableScript?enable=' + enable, true);
  request.onload = function () {
    if (request.status >= 200 && request.status < 400) { // Success!
      var resp = JSON.parse(request.responseText);
      scriptInstalled();
    } else { // We reached our target server, but it returned an error
      console.warn('PodBuzzz API returned an error.');
    }
  };
  request.onerror = function () { // There was a connection error of some sort
    console.warn('Could not connect to PodBuzzz API.');
  };
  request.send();
}

function scriptIsEnabled() {
  var request = new XMLHttpRequest();
  request.open('GET', homeUrl + '/podbuzzz_api/scriptIsEnabled', true);
  request.onload = function () {
    if (request.status >= 200 && request.status < 400) { // Success!
      var resp = JSON.parse(request.responseText);
      document.getElementById('podbuzzzScriptEnabled').checked = resp.enabled;
    } else { // We reached our target server, but it returned an error
      console.warn('PodBuzzz API returned an error.');
    }
  };
  request.onerror = function () { // There was a connection error of some sort
    console.warn('Could not connect to PodBuzzz API.');
  };
  request.send();
}

function getHomeUrl() {
  var href = window.location.href;
  var index = href.indexOf('/wp-admin');
  var homeUrl = href.substring(0, index);
  return homeUrl;
}

getKey();
scriptInstalled();
scriptIsEnabled();
