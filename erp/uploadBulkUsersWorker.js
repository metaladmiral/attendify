self.onmessage = (e) => {
    let xml = new XMLHttpRequest();
    xml.onreadystatechange = function() {
        if(this.readyState==4 && this.status==200) {
            let resp = this.responseText;
            self.postMessage(resp);
        }
    }
    let fd = new FormData();
    fd.set('data', e.data);
    xml.open("POST", "../assets/backend/add-users-bulk.php", false);
    xml.send(fd);
}