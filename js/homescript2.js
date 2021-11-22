
    function myVechicle(selectedObject) {
    // Get the checkbox
    // Get the output text

    var field1 = document.getElementById("oneField");
    var label1 = document.getElementById("oneLabel");
    var field2 = document.getElementById("twoField");
    var label2 = document.getElementById("twoLabel");
    var field3 = document.getElementById("threeField");
    var label3 = document.getElementById("threeLabel");
    var field4 = document.getElementById("fourField");
    var label4 = document.getElementById("fourLabel");
    var field5 = document.getElementById("fiveField");
    var label5 = document.getElementById("fiveLabel");

    var field11 = document.getElementById("vehicletype1");
    var label11 = document.getElementById("Label1");
    var field22 = document.getElementById("vehicletype2");
    var label22 = document.getElementById("Label2");
    var field33 = document.getElementById("vehicletype3");
    var label33 = document.getElementById("Label3");
    var field44 = document.getElementById("vehicletype4");
    var label44 = document.getElementById("Label4");
    var field55 = document.getElementById("vehicletype5");
    var label55 = document.getElementById("Label5");
    // If the checkbox is checked, display the output text
    if(selectedObject =="0"){
      field1.style.display = "none";
      label1.style.display = "none";
      field2.style.display = "none";
      label2.style.display = "none";
      field3.style.display = "none";
      label3.style.display = "none";
      field4.style.display = "none";
      label4.style.display = "none";
      field5.style.display = "none";
      label5.style.display = "none";

      field11.style.display = "none";
      label11.style.display = "none";
      field22.style.display = "none";
      label22.style.display = "none";
      field33.style.display = "none";
      label33.style.display = "none";
      field44.style.display = "none";
      label44.style.display = "none";
      field55.style.display = "none";
      label55.style.display = "none";

      field1.disabled = true;
      label1.disabled =true;
      field2.disabled = true;
      label2.disabled =true;
      field3.disabled = true;
      label3.disabled =true;
      field4.disabled = true;
      label4.disabled =true;
      field5.disabled = true;
      label5.disabled =true;

      field11.disabled = true;
      label11.disabled =true;
      field22.disabled = true;
      label22.disabled =true;
      field33.disabled = true;
      label33.disabled =true;
      field44.disabled = true;
      label44.disabled =true;
      field55.disabled = true;
      label55.disabled =true;

    }
    else if (selectedObject == "1"){
    field1.style.display = "block";
    label1.style.display = "block";
    field2.style.display = "none";
    label2.style.display = "none";
    field3.style.display = "none";
    label3.style.display = "none";
    field4.style.display = "none";
    label4.style.display = "none";
    field5.style.display = "none";
    label5.style.display = "none";

    field11.style.display = "block";
    label11.style.display = "block";
    field22.style.display = "none";
    label22.style.display = "none";
    field33.style.display = "none";
    label33.style.display = "none";
    field44.style.display = "none";
    label44.style.display = "none";
    field55.style.display = "none";
    label55.style.display = "none";

    field1.disabled = false;
    label1.disabled = false;
    field2.disabled = true;
    label2.disabled =true;
    field3.disabled = true;
    label3.disabled =true;
    field4.disabled = true;
    label4.disabled =true;
    field5.disabled = true;
    label5.disabled =true;

    field11.disabled = false;
    label11.disabled =false;
    field22.disabled = true;
    label22.disabled =true;
    field33.disabled = true;
    label33.disabled =true;
    field44.disabled = true;
    label44.disabled =true;
    field55.disabled = true;
    label55.disabled =true;
  } else if (selectedObject == "2"){
    field1.style.display = "block";
    label1.style.display = "block";
    field2.style.display = "block";
    label2.style.display = "block";
    field3.style.display = "none";
    label3.style.display = "none";
    field4.style.display = "none";
    label4.style.display = "none";
    field5.style.display = "none";
    label5.style.display = "none";

    field11.style.display = "block";
    label11.style.display = "block";
    field22.style.display = "block";
    label22.style.display = "block";
    field33.style.display = "none";
    label33.style.display = "none";
    field44.style.display = "none";
    label44.style.display = "none";
    field55.style.display = "none";
    label55.style.display = "none";

    field1.disabled = false;
    label1.disabled = false;
    field2.disabled = false;
    label2.disabled = false;
    field3.disabled = true;
    label3.disabled = true;
    field4.disabled = true;
    label4.disabled = true;
    field5.disabled = true;
    label5.disabled = true;

    field11.disabled = false;
    label11.disabled = false;
    field22.disabled = false;
    label22.disabled = false;
    field33.disabled = true;
    label33.disabled = true;
    field44.disabled = true;
    label44.disabled = true;
    field55.disabled = true;
    label55.disabled = true;
  } else if (selectedObject == "3"){
    field1.style.display = "block";
    label1.style.display = "block";
    field2.style.display = "block";
    label2.style.display = "block";
    field3.style.display = "block";
    label3.style.display = "block";
    field4.style.display = "none";
    label4.style.display = "none";
    field5.style.display = "none";
    label5.style.display = "none";

    field11.style.display = "block";
    label11.style.display = "block";
    field22.style.display = "block";
    label22.style.display = "block";
    field33.style.display = "block";
    label33.style.display = "block";
    field44.style.display = "none";
    label44.style.display = "none";
    field55.style.display = "none";
    label55.style.display = "none";

    field1.disabled = false;
    label1.disabled = false;
    field2.disabled = false;
    label2.disabled = false;
    field3.disabled = false;
    label3.disabled = false;
    field4.disabled = true;
    label4.disabled = true;
    field5.disabled = true;
    label5.disabled = true;

    field11.disabled = false;
    label11.disabled = false;
    field22.disabled = false;
    label22.disabled = false;
    field33.disabled = false;
    label33.disabled = false;
    field44.disabled = true;
    label44.disabled = true;
    field55.disabled = true;
    label55.disabled = true;
  } else if (selectedObject == "4"){
    field1.style.display = "block";
    label1.style.display = "block";
    field2.style.display = "block";
    label2.style.display = "block";
    field3.style.display = "block";
    label3.style.display = "block";
    field4.style.display = "block";
    label4.style.display = "block";
    field5.style.display = "none";
    label5.style.display = "none";

    field11.style.display = "block";
    label11.style.display = "block";
    field22.style.display = "block";
    label22.style.display = "block";
    field33.style.display = "block";
    label33.style.display = "block";
    field44.style.display = "block";
    label44.style.display = "block";
    field55.style.display = "none";
    label55.style.display = "none";

    field1.disabled = false;
    label1.disabled = false;
    field2.disabled = false;
    label2.disabled = false;
    field3.disabled = false;
    label3.disabled = false;
    field4.disabled = false;
    label4.disabled = false;
    field5.disabled = true;
    label5.disabled = true;

    field11.disabled = false;
    label11.disabled = false;
    field22.disabled = false;
    label22.disabled = false;
    field33.disabled = false;
    label33.disabled = false;
    field44.disabled = false;
    label44.disabled = false;
    field55.disabled = true;
    label55.disabled = true;
  } else if (selectedObject == "5"){
    field1.style.display = "block";
    label1.style.display = "block";
    field2.style.display = "block";
    label2.style.display = "block";
    field3.style.display = "block";
    label3.style.display = "block";
    field4.style.display = "block";
    label4.style.display = "block";
    field5.style.display = "block";
    label5.style.display = "block";

    field11.style.display = "block";
    label11.style.display = "block";
    field22.style.display = "block";
    label22.style.display = "block";
    field33.style.display = "block";
    label33.style.display = "block";
    field44.style.display = "block";
    label44.style.display = "block";
    field55.style.display = "block";
    label55.style.display = "block";

    field1.disabled = false;
    label1.disabled = false;
    field2.disabled = false;
    label2.disabled = false;
    field3.disabled = false;
    label3.disabled = false;
    field4.disabled = false;
    label4.disabled = false;
    field5.disabled = false;
    label5.disabled = false;

    field11.disabled = false;
    label11.disabled = false;
    field22.disabled = false;
    label22.disabled = false;
    field33.disabled = false;
    label33.disabled = false;
    field44.disabled = false;
    label44.disabled = false;
    field55.disabled = false;
    label55.disabled = false;
  }
    }
