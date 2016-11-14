Date.timeBetween = function( time1, time2 ) {
  //Get 1 day in milliseconds
  var one_day=60*60*24;
  var one_hour=60*60;
  var one_min=60;

  // Convert both dates to milliseconds
  var time1_ms = time1.getTime()/1000;
  var time2_ms = time2.getTime()/1000;

  // Calculate the difference in milliseconds
  var difference_ms = time2_ms - time1_ms;
    
  // Convert back to days and return
  if(difference_ms>86400){
  return time1.toLocaleDateString()+"  "+"at"+"  "+time1.toLocaleTimeString(); 
  }
  if(difference_ms>3600){
  return Math.round(difference_ms/one_hour)+"hrs"; 
  }
  if(difference_ms>60){
  return Math.round(difference_ms/one_min)+"mins"; 
  }
  else{
      return ("Just now");
      //return (difference_ms.toFixed(0))+"sec";
  }
}