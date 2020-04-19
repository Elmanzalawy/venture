$(document).ready(function(){

//add random background to homepage
//too add more backgrounds, add the background names to the backgrounds array, and move the image to public/images
var stage = $('#stage');
var backgrounds = ['groupPhoto1.jpg','groupPhoto2.jpg','groupPhoto3.jpg','groupPhoto4.jpg','groupPhoto5.jpg','groupPhoto6.jpg'];
var getBg = Math.floor(Math.random()*backgrounds.length);
stage.css('background',"url("+'images/'+backgrounds[getBg]+") no-repeat center");
stage.css('background-size',"cover");
});