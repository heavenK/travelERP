// main.js
var clip = new ZeroClipboard( document.getElementById("copy-button"), {
  moviePath: "Public/myerp/zeroclipboard-master/ZeroClipboard.swf"
} );

clip.on( 'load', function(client) {
  // alert( "movie is loaded" );
} );

clip.on( 'complete', function(client, args) {
  //this.style.display = "none"; // "this" is the element that was clicked
  if(args.text == '')
  alert("请填写行程二");
  else
  alert("行程已复制到粘贴板上");
} );

clip.on( 'mouseover', function(client) {
  // alert("mouse over");
} );

clip.on( 'mouseout', function(client) {
  // alert("mouse out");
} );

clip.on( 'mousedown', function(client) {

  // alert("mouse down");
} );

clip.on( 'mouseup', function(client) {
  // alert("mouse up");
} );