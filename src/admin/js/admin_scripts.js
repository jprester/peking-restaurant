function myAlert() {
  if (confirm('Jeste li sigurni da želite obrisati jelo ?') == false) {
    event.preventDefault();
  } else {
    alert('Obrisali ste jelo!');
  }

  // document.getElementById("delBtn").submit();
}
