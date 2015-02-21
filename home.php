<?php
session_start();
$username=$_SESSION['username'];
?>
<html>
    <title>Home</title>
    <head>
		<style>
			#popup{
            position:fixed;
            top:0px;
            bottom:0px;
            left:0px;
            right:0px;
            text-align:center;
            opacity:0;
            background-color:rgba(0,0,0,0.8);
            z-index:9999;
            -webkit-transition: opacity 400ms ease-in;
	       -moz-transition: opacity 400ms ease-in;
	       transition: opacity 400ms ease-in;
	       pointer-events: none;
        }
         #popup:target
        {
            opacity:1;
            pointer-events: auto;
        }
			#inside
        {
            border-radius:5px;
            margin-top:270px;
            width:30%;
            display:block;
            background-color:white;
            margin-left:auto;
            margin-right:auto;
            padding:20px 0px;
            padding-top:10px;
        }
        #close:target{
            opacity:0;
            pointer-events: none;
        }
.header
        {
            font:22px sans-serif;
            padding:0px;
            border-bottom:1px solid #ccc9c9;
            padding-bottom:10px;
            margin-bottom:15px;
        }
        #info{
            font:12px sans-serif;
            text-align:right;
            color:gray;
        }
		</style>
		<script src="jquery-2.1.3.min.js"></script>
		<script src="http://maps.googleapis.com/maps/api/js"></script>
		<script>
			var myCenter;
			var lat,lng;
			function initialize() {
				
  				var mapProp = {
				center:new google.maps.LatLng(51.508742,-0.120850),
    			zoom:5,
    			mapTypeId:google.maps.MapTypeId.ROADMAP
  				};
  				var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);
				var marker=new google.maps.Marker({
  					position:myCenter,
  				});
				marker.setMap(map);
				
				google.maps.event.addListener(map, "click", function (e)
				{
					//alert(e.latLng);
					myCenter=new google.maps.LatLng(e.latLng.lat(),e.latLng.lng());
					lat=e.latLng.lat();
					lng=e.latLng.lng();
					change(e.latLng.lat(),e.latLng.lng());
				});
				google.maps.event.addListener(map, 'rightclick', function(event) {
				//Edit form to be displayed with new marker
				var EditForm = '<p><div class="marker-edit">'+
				'<form action="ajax-save.php" method="POST" name="SaveMarker" id="SaveMarker">'+
				'<input type="text" name="pName" class="save-name" placeholder="Enter Title" maxlength="40" />'+
				'</form>'+
				'</div></p><button name="save-marker" class="save-marker">Save Marker Details</button>';

				//Drop a new Marker with our Edit Form
				create_marker(event.latLng, 'New Marker', EditForm, true, true, true, "http://maps.google.com/mapfiles/ms/micons/blue.png");
			});
					function create_marker(MapPos, MapTitle, MapDesc,  InfoOpenDefault, DragAble, Removable, iconPath)
	{	  	  		  
		
		//new marker
		var marker = new google.maps.Marker({
			position: MapPos,
			map: map,
			draggable:DragAble,
			animation: google.maps.Animation.DROP,
			title:"Hello World!",
			icon: iconPath
		});
		google.maps.event.addListener(marker,'dblclick',function() {
  		//alert("jkcej");
		window.location.hash="popup";
  		map.setCenter(marker.getPosition());
  		});
		//Content structure of info Window for the Markers
		var contentString = $('<div class="marker-info-win">'+
		'<div class="marker-inner-win"><span class="info-content">'+
		'<h1 class="marker-heading">'+MapTitle+'</h1>'+
		MapDesc+ 
		'</span><button name="remove-marker" title="Remove Marker">Remove Marker</button>'+
		'</div></div>');	

		
		//Create an infoWindow
		var infowindow = new google.maps.InfoWindow();
		//set the content of infoWindow
		infowindow.setContent(contentString[0]);

		//Find remove button in infoWindow
		var removeBtn 	= contentString.find('button.remove-marker')[0];
		var saveBtn 	= contentString.find('button.save-marker')[0];

		//add click listner to remove marker button
		google.maps.event.addDomListener(removeBtn, "click", function(event) {
			remove_marker(marker);
		});
		
		if(typeof saveBtn !== 'undefined') //continue only when save button is present
		{
			//add click listner to save marker button
			google.maps.event.addDomListener(saveBtn, "click", function(event) {
				var mReplace = contentString.find('span.info-content'); //html to be replaced after success
				var mName = contentString.find('input.save-name')[0].value; //name input field value
				var mDesc  = contentString.find('textarea.save-desc')[0].value; //description input field value
				var mType = contentString.find('select.save-type')[0].value; //type of marker
				
				if(mName =='' || mDesc =='')
				{
					alert("Please enter Name and Description!");
				}else{
					save_marker(marker, mName, mDesc, mType, mReplace); //call save marker function
				}
			});
		}
		function save_marker(Marker, mName, mAddress, mType, replaceWin)
	{
		//Save new marker using jQuery Ajax
		var mLatLang = Marker.getPosition().toUrlValue(); //get marker position
		var myData = {name : mName, latlang : mLatLang, type : mType }; //post variables
		console.log(replaceWin);		
		$.ajax({
		  type: "POST",
		  url: "savemap.php",
		  data: myData,
		  success:function(data){
				replaceWin.html(data); //replace info window with new html
				Marker.setDraggable(false); //set marker to fixed
				Marker.setIcon('http://maps.google.com/mapfiles/ms/micons/blue.png'); //replace icon
            },
            error:function (xhr, ajaxOptions, thrownError){
                alert(thrownError); //throw any errors
            }
		});
	}

		//add click listner to save marker button		 
		google.maps.event.addListener(marker, 'click', function() {
				infowindow.open(map,marker); // click on marker opens info window 
	    });
		  
		if(InfoOpenDefault) //whether info window should be open by default
		{
		  infowindow.open(map,marker);
		}
	}

				        function addMyMarker() { //function that will add markers on button click
            var marker = new google.maps.Marker({
                position:mapCenter,
                map: map,
                  draggable:true,
                  animation: google.maps.Animation.DROP,
                title:"This a new marker!",
              icon: "http://maps.google.com/mapfiles/ms/micons/blue.png"
            });
        }
			}
			$("#save").click(function(){
				var email=$("#email").val();
				var location=$("#location").val();
				alert(lat);
		$.ajax({
			
			url:"save.php?email="+email+"&location="+location+"&lat="+lat+"&lng="+lng,
			type:"GET",
			success:function(data)
			{
        		$("#preferences").show();
        		$("#updatepreferences").hide();
			}
		});
		});
							
			google.maps.event.addDomListener(window, 'load', initialize);
		</script>
    </head>
    <link rel="stylesheet" type="text/css" href="bootstrap.css" />
    <body>
		<div><a href="logout.php"><button class="btn btn-danger">Logout</button></a></div>
    	<div id="googleMap" style="width:500px;height:380px;"></div>
		
		<div id="popup" class="popup">
            <div id='align'>
            <div id="inside">
            <div class="header">Save Your Location</div>
            <div>
            	Location Name: <input type="text" name="location" required><br><br>
            	<input type="submit" id="save" name="save" value="Save">
            	<a href="#"><input type="button" id="close" name="close" value="Cancel"></a>
				<input type="hidden" name="email" id="email" value="<?=$_SESSION['email'];?>">
				</div>
        </div></div></div>
		
			
    </body>
</html>