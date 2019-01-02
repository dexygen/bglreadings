function ajax(method, url, success, failure) {
    var xhr = new XMLHttpRequest();
    xhr.open(method, url, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status >= 200 && xhr.status <= 299) {
                success(xhr.response);
            } else {
                failure(xhr.response);
            }
        }
    }
    xhr.send();
    return xhr;
}