function ajax(method, url, success, failure, params) {
  var xhr = new XMLHttpRequest();
  var postParamsStr;
  xhr.open(method, url, true);
  
  if (method.toUpperCase(method) === 'POST') {
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    postParamsStr = (function() {
      var paramsStr;
      var paramsArr = [];
      
      for (var param in params) {
        paramsArr.push(param + "=" + params[param]);
      }
      if (paramsArr.length) {
        paramsStr = paramsArr.join("&");
      }
      
      return paramsStr;
    })();
  }
  
  xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status >= 200 && xhr.status <= 299) {
              success(xhr.response);
          } else {
              failure(xhr.response);
          }
      }
  }

  postParamsStr ? xhr.send(postParamsStr) : xhr.send();
  return xhr;
}