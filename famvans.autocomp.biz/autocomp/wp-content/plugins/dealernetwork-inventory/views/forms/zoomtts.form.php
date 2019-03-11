
<?php
//----------------------------------------------------------
// variables for website design

$zoomTTSWidth = 800; //maximum
$zoomTTSHeight = 800; //maximum

//BUG: fix last slide not transitioning back to first properly. it seems the last slide has a higher z-index than the first.
//----------------------------------------------------------

$imagesToDisplay = $car->ImageUrls;
if(count($imagesToDisplay) < 1) $imagesToDisplay[] = 'http://www.dealernetwork.com/images/inventory/nopicture1.jpg';


$zoomImgInitialSize = getImageSize($imagesToDisplay[0]);
$zoomImgDimensionRatio = $zoomImgInitialSize[0] / $zoomImgInitialSize[1];  // width/height
$zoomImgStretchHeight = (int) ($zoomTTSWidth / $zoomImgDimensionRatio);
if ($zoomImgStretchHeight < $zoomTTSHeight) $zoomTTSHeight = $zoomImgStretchHeight;

//if($car->Description)
//{
//    echo '<audio id="zoomAudio" controls>
//         <source src="http://api.voicerss.org/?key=3b016b834db94c19b824f3e0c045ecc3&src='.urlencode($car->Year $car->Make $car->Model $car->Description).'&hl=en-us&f=8khz_8bit_mono" />
//         </audio>';
//}
//?>

<script>

    var zoomDivPositionX = (screen.availWidth - <?php echo $zoomTTSWidth; ?>) / 2;
    var zoomDivPositionY = (screen.availHeight - <?php echo $zoomTTSHeight; ?>) / 2;
    var zoomIntv;
    var cycleSpeed = 5000;
    var expandAmount = <?php echo $zoomTTSWidth; ?> * 0.7;
    var shiftAmount = expandAmount / 2;
    var zoomHtml;
    var zoomCount = <?php echo count($imagesToDisplay); ?>;

</script>

<button id='zoomTTSbutton'>Play</button>

<div id='zoomTTSVideo' style='
    width:0px;
    height:0px;
    display: inline-block;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1005;
    overflow: hidden;'>
</div>

<div id='zoomSmokeScreen' style='
     width: 0px;
     height: 0px;
     top: 0px;
     left: 0px;
     position: fixed;
     z-index: 1004;
     background-color: black;
     opacity: 0.9;'>
</div>

<script>
    jQuery('#zoomTTSbutton').click(function(event)
    {
        event.preventDefault();

        jQuery('#zoomSmokeScreen').animate({height: screen.availHeight, width: screen.availWidth},{queue: false, duration: 0});
        jQuery('#zoomTTSVideo').animate({left: screen.availWidth/2, top: screen.availHeight/2}, {duration: 0});
        jQuery('#zoomTTSVideo').animate({width: '<?php echo $zoomTTSWidth; ?>', height: '<?php echo $zoomTTSHeight; ?>', left: zoomDivPositionX, top: zoomDivPositionY});
        
        zoomHtml = '<div id="imgContainer" style=" height:<?php echo $zoomTTSHeight; ?>px; width:<?php echo $zoomTTSWidth; ?>px; overflow: hidden; position: relative;">';
        <?php
        foreach($imagesToDisplay as $key => $imgUrl)
        {
            ?>
            zoomHtml += '<img src="<?php echo $imgUrl; ?>" id="zoom<?php echo $key; ?>" style="width: 100%; position: absolute; max-width: none !important;">';
            <?php
        }
        ?>
        zoomHtml += '</div>';
        if (<?php echo json_encode($car->Description); ?>)
        {
            zoomHtml += '<embed id="zoomTTSspeech" hidden="true" src="http://api.voicerss.org/?key=3b016b834db94c19b824f3e0c045ecc3&src=<?php echo urlencode($car->Description); ?>&hl=en-us&f=8khz_8bit_mono\" />';
        }

        jQuery('#zoomTTSVideo').empty().append(zoomHtml);

        for(var i = 1; i < zoomCount; i++)
        {
            jQuery('#zoom'+i).css('display', 'none');
        }

        var zoomI = 0;
        function zoom()
        {
            jQuery('#zoom'+zoomI).fadeIn(cycleSpeed * 0.4);
            jQuery('#zoom'+zoomI).animate({height: '+='+expandAmount, width: '+='+expandAmount},{queue: false, duration: (cycleSpeed + (cycleSpeed * 0.4)), easing: 'linear'}).animate({left: '-='+shiftAmount, top: '-='+shiftAmount}, {queue: false, duration: (cycleSpeed + (cycleSpeed * 0.4)), easing: 'linear'});
            jQuery('#zoom'+zoomI).delay(cycleSpeed + (cycleSpeed * 0.41)).animate({height: '-='+expandAmount, width: '-='+expandAmount, left: '0', top: '0'}, 0).fadeOut(0);
            zoomI = (zoomI+1)%zoomCount;
        }

        if(zoomCount > 1)
        {
            zoom();
            zoomIntv = setInterval(zoom, cycleSpeed);
        }

    });
    
    jQuery('#zoomSmokeScreen').click(function()
    {
        clearInterval(zoomIntv);
        jQuery('#zoomTTSspeech').remove();
        jQuery('#imgContainer').remove();
        jQuery('#zoomTTSVideo').finish().animate({width: '0', height: '0', left: '0', top: '0'}, {duration: 0, queue: false});
        jQuery('#zoomSmokeScreen').finish().animate({height: '0px', width: '0px', top: '0px', left: '0px'}, {duration: 0, queue: false});
    });
</script>