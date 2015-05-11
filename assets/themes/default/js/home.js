   //map
   function initialize() {
                var mapCanvas = document.getElementById('map-canvas');
                var maptooltipbold = 'Robios';
                var maptooltip = '19a Galway Ave,<br>Bryndwr,<br>Christchurch';
                var myLatLng = new google.maps.LatLng(-43.509061, 172.599114);
                var mapOptions = {
                    zoom: 16,
                    scrollwheel: false,
                    center: myLatLng
                };
                var map = new google.maps.Map(mapCanvas, mapOptions);
                map.set('styles', [
                    {
                        featureType: 'landscape',
                        elementType: 'geometry',
                        stylers: [
                            {hue: '#fafcfd'},
                        ]
                    }
                ]);

                var image = '';
                var content = document.createElement('div');
                content.innerHTML = "<div class=" + "map-tooltip" + "><h4><strong>" + maptooltipbold + "</strong></h4><hr>" + "<h5>" + maptooltip + "</h5></div>";
                var infowindow = new google.maps.InfoWindow({
                    content: content
                });

                var marker = new google.maps.Marker({
                    position: myLatLng,
                    map: map,
                    draggable: false,
                    scrollwheel: false,
                    icon: image,
                    animation: google.maps.Animation.BOUNCE
                });
                google.maps.event.addListener(marker, 'click', function() {
                    infowindow.open(map, marker);
                });
            }
           
 
 

        $(document).ready(function() {
        
            //enquiry form
            $("#frm-enquiry").submit(function(e) {
                e.preventDefault();              
                    var url = $(this).attr('action');
                    var method = $(this).attr('method');
                    var data = $(this).serialize();
                    $.ajax({
                        url: url,
                        type: method,
                        data: data
                    }).done(function(data) {
                        if (data === "success") {
                            $('#enquiry-successmsg').removeClass('hidden');
                            $('#frm-enquiry').addClass('hidden');
                            $('#enquiry-content').append('<div class="modal-body"><div id="enquiry-successmsg" class="alert alert-success" role="alert">Thank you for contacting us. We will be in touch to discuss your requirements.</div></div>')
                        } else if (data === "fail") {
                            $('#enquiry-fail-errormsg').removeClass('hidden');
                        }
                    });
            });
        });
        
        function setEnquiryModalTitle(title){
            $("#enquiry-title").html('<i class=\'fa fa-paper-plane\'></i> Enquiry: '+title);
            $("#enquiry-type").val(title);
        }
