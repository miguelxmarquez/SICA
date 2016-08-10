<html>
    <head>

        <script type="text/javascript" src="jquery-1.3.2.min.js"></script>
        <script type="text/javascript" src="jquery-barcode-2.0.2.min.js"></script>
        <script type="text/javascript">
    
            function generateBarcode(){
                var value = "<?php echo $ci ?>";
                var btype = "codabar";
                var renderer = "bmp";
        
                var quietZone = false;
                if ($("#quietzone").is(':checked') || $("#quietzone").attr('checked')){
                    quietZone = true;
                }
		
                var settings = {
                    output:renderer,
                    bgColor: "#FFFFFF",
                    color: "#000000",
                    barWidth: "2",
                    barHeight: "35"
                };
                if ($("#rectangular").is(':checked') || $("#rectangular").attr('checked')){
                    value = {code:value, rect: true};
                }
                if (renderer == 'canvas'){
                    clearCanvas();
                    $("#barcodeTarget").hide();
                    $("#canvasTarget").show().barcode(value, btype, settings);
                } else {
                    $("#canvasTarget").hide();
                    $("#barcodeTarget").html("").show().barcode(value, btype, settings);
                }
            }
          
            function showConfig1D(){
                $('.config .barcode1D').show();
                $('.config .barcode2D').hide();
            }
      
            function showConfig2D(){
                $('.config .barcode1D').hide();
                $('.config .barcode2D').show();
            }
      
            function clearCanvas(){
                var canvas = $('#canvasTarget').get(0);
                var ctx = canvas.getContext('2d');
                ctx.lineWidth = 1;
                ctx.lineCap = 'butt';
                ctx.fillStyle = '#FFFFFF';
                ctx.strokeStyle  = '#000000';
                ctx.clearRect (0, 0, canvas.width, canvas.height);
                ctx.strokeRect (0, 0, canvas.width, canvas.height);
            }
      
            $(function(){
                $('input[name=btype]').click(function(){
                    if ($(this).attr('id') == 'datamatrix') showConfig2D(); else showConfig1D();
                });
                $('input[name=renderer]').click(function(){
                    if ($(this).attr('id') == 'canvas') $('#miscCanvas').show(); else $('#miscCanvas').hide();
                });
                generateBarcode();
            });
  
        </script>
    </head>

    <body onload="generateBarcode();">

        <div id="barcodeTarget" class="barcodeTarget"></div>
        <canvas id="canvasTarget" width="150" height="150"></canvas> 
    </body>
</html>