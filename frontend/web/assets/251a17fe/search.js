function doSearch() {
  var input, filter, table, tr, td1, td2, td3, i, text;
  input = document.getElementById("dosearch");
  filter = input.value;
  table = document.getElementById("works");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td1 = tr[i].getElementsByTagName("td")[0];
    td2 = tr[i].getElementsByTagName("td")[1];
    td3 = tr[i].getElementsByTagName("td")[2];
    if (td1 && td2 && td3) {
	  text = td1.innerHTML + ' ' + td2.innerHTML + ' ' + td3.innerHTML;
      text = text.replace(/\n/g, "").replace(/  +/g, ' ');
      if (text.indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }     
  }
}
