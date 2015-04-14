
// http://stackoverflow.com/questions/1692184/converting-epoch-time-to-real-date-time

var cvt_timezone = true;

//calc tz one time
var dtmp = new Date();
var tzoffset_min = dtmp.getTimezoneOffset();

function cvt(secs){
  var o = {};
  o.seconds = secs %60;
  secs = secs/60;
  if (cvt_timezone) {
    secs = secs - tzoffset_min;
  }
  o.minutes = secs%60;
  secs = secs/60;
  o.hours = secs%24;
  return o;
}

function timehandler() {
  var ms = Date.now()
  var secs = ms/1000;
  var tm = cvt(secs);  
  //$("#time_secs").html(tm.seconds);
  $("#time_secs").html(Date.now);
  $("#time_mins").html(tm.minutes);
  $("#time_hours").html(tm.hours);
  
  tm.seconds = Math.floor(tm.seconds);
  tm.hours = Math.floor(tm.hours);
  tm.minutes = Math.floor(tm.minutes);
  if (tm.seconds < 10) {
    tm.seconds = "0" + tm.seconds;
  }
  if (tm.hours<10) {
    tm.hours = "0" + tm.hours;
  }
  if (tm.minutes<10) {
    tm.minutes = "0" + tm.minutes;
  }
  
  var cs = "" + tm.seconds + 
      tm.minutes +
      tm.hours;
  
  $("#hcode").html(cs);
  $("#h").css("background", "#"+cs);
  
  window.setTimeout(timehandler,1000);
}

window.onload = timehandler;