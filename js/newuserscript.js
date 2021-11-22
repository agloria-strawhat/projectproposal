  function myFunction(selectedObject) {
// Get the checkbox
// Get the output text

var field = document.getElementById("clubField");
var club = document.getElementById("clubLabel");
// If the checkbox is checked, display the output text
if (selectedObject == "CLUB"){
field.style.display = "block";
club.style.display = "block";
} else {
field.style.display = "none";
club.style.display = "none";
}
}