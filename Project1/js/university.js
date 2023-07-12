function sortCurrentField(u,v,w) {
    document.location.href = "index.php?mn=" +u + "&cn=" + v + "&dir=" + w;
}

function addNewRow() {
    $("#newdatadiv").hide();
    $("#datainputdiv").show();
}

function editThisRow(x,y,u) {
    var mn = $("#mn").val();
    var myurl = "getDataByRow.php?fd1=" + x + "&fd2=" + y + "&mn=" + mn; 
    
    $.get(myurl,fuction(data,status){
         var rowarr = JSON.parse(this.responseText);
         var length = Object.keys(rowarr).length;
         $("#numcols").val(length);
        
        for (let i = 0; i < length; i++) {
            $('#R' + u + "C" + i).html("<input id='fd" + u + "c" + i + "' type='text' value='" + rowarr[i] + "' size='6' />");
        }
        $("#editbtndiv" + u).hide();
        $("#updtbtndiv" + u).show();
        
    };
   
}

function updateThisRow(x,y,u) {
    var mn = $("#mn").val();
    var numcols = parseInt($("#numcols").val());
    var dat = $("#fd" + u +"c0").val();
    var crtval = "";
    
    var oldfd1 = dat;
    var oldfd2 = $("#fd" + u + "c1").val();
    $("#R" + u + "C0").html(dat);
   
    
    for (let i = 1; i < numcols; i++) {
        crtval = $("#fd" + u + "c" + i).val();
        dat = dat + "@--@" + crtval;
        $("#R" + u + "C" + i).html(crtval);
    }
    
    var myurl = "setDataByRow.php?fd1=" + x + "&fd2=" + y + "&mn=" + mn + "&dat=" + dat;
    
    $.get(myurl,fuction(data,status){
        $("#editbtndiv" + u).show();
        $("#updtbtndiv" + u).hide();
        
        $("#editbtndiv" + u).html("<input type='button' onclick=\"editThisRow('" + oldfd1 + "','" + oldfd2 + "'," + u + ")\" value='Edit'/>");
        $("#updtbtndiv" + u).html("<input type='button' onclick=\"updateThisRow('" + oldfd1 + "','" + oldfd2 + "'," + u + ")\" value='Update'/>");
        $("#delbtn" + u).html("<input type='button' onclick=\"delThisRow('" + oldfd1 + "','" + oldfd2 + "')\" value='Del'/>");
    };

    
}

function delThisRow(x,y) {
    var mn = document.getElementById("mn").value;
    var myurl = "delDataByRow.php?fd1=" + x + "&fd2=" + y + "&mn=" + mn;
    
    document.location.href = myurl;
}

function showMaxVal(u) {
    const xhttp = new XMLHttpRequest();
    var mn = document.getElementById("mn").value;
    var myurl = "getMaxValue.php?mn=" + u;
    
    xhttp.onload = function () {
        
        document.getElementById("mymax").innerHTML = this.responseText;
        //document.getElementById("mymax").style.display = "block";
        
    };
    
    xhttp.open("GET", myurl, true);
    xhttp.send();
}