
var OneQresult;
var TwoQresult;
var ThreeQresult;
var FourQresult;
var rounded = function(number){
    return +number.toFixed(2);
}


function Qcount(fm,sm,tm){
      if (isNaN(fm)==true) fm=0;
      if (isNaN(sm)==true) sm=0;
			if (isNaN(tm)==true) tm=0;
		  if (fm+sm+tm == 0) return 0;
return  rounded(((fm + sm + tm)+1)/3);

}


function Q1() {
var jan = parseInt(document.getElementById('edit-100500-0-jan').value);
var feb = parseInt(document.getElementById('edit-100500-0-feb').value);
var mar = parseInt(document.getElementById('edit-100500-0-mar').value);
//Q1 end
//var q = jan + feb + mar;
var q =Qcount(jan, feb, mar);
document.getElementById('edit-100500-0-q1').value =  q;
OneQresult = q;
return OneQresult;
}

function Q1_edit(){
var q1 = parseInt(document.getElementById('edit-100500-0-q1').value);

}

function Q2(){
//Q2 start
var apr = parseInt(document.getElementById('edit-100500-0-apr').value);
var may = parseInt(document.getElementById('edit-100500-0-may').value);
var jun = parseInt(document.getElementById('edit-100500-0-jun').value);
//Q2 end
var q = Qcount(apr, may, jun);
document.getElementById('edit-100500-0-q2').value =  q;
TwoQresult = q;
return TwoQresult;
}

function Q3(){
//Q3 start
var jul = parseInt(document.getElementById('edit-100500-0-jul').value);
var aug = parseInt(document.getElementById('edit-100500-0-aug').value);
var sep = parseInt(document.getElementById('edit-100500-0-sep').value);
//Q3 end
var q = Qcount(jul, aug, sep);
document.getElementById('edit-100500-0-q3').value =  q;
ThreeQresult = q;
return ThreeQresult;
}

function Q4(){
//Q4 start
var oct = parseInt(document.getElementById('edit-100500-0-oct').value);
var nov = parseInt(document.getElementById('edit-100500-0-nov').value);
var dec = parseInt(document.getElementById('edit-100500-0-dec').value);
//Q4 end
var q = Qcount(oct, nov, dec);
document.getElementById('edit-100500-0-q4').value =  q;
FourQresult = q;
return FourQresult;
}


function YTD(){
      if (isNaN(OneQresult)==true) OneQresult=0;
      if (isNaN(TwoQresult)==true) TwoQresult=0;
			if (isNaN(ThreeQresult)==true) ThreeQresult=0;
			if (isNaN(FourQresult)==true) FourQresult=0;
			if (OneQresult+TwoQresult+ThreeQresult+FourQresult == 0) return document.getElementById('edit-100500-0-ytd').value = 0;


var year = rounded(((OneQresult+TwoQresult+ThreeQresult+FourQresult)+1)/4);
document.getElementById('edit-100500-0-ytd').value =  year;
}
