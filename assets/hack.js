$(document).ready(function() {

  function getBlocks(blockDate) {
  
    /* all blockw come from Trove for now */
    fillBlock('block1', 'trove', blockDate, 'article');
    fillBlock('block2', 'trove', blockDate, 'article');
    fillBlock('block3', 'trove', blockDate, 'article');
    fillBlock('block4', 'trove', blockDate, 'article');
    fillBlock('block5', 'trove', blockDate, 'article');
    fillBlock('picture1', 'trove', blockDate, 'picture');
    
  }

  function fillBlock(blockId, blockType, blockDate, blockZone) {
    var blockEl = $('#'+blockId);

    $.ajax({
      url: "assets/getblock.php?type="+blockType+"&date="+blockDate+"&zone="+blockZone+"&elid="+blockId,
      beforeSend: function() {
        blockEl.removeClass('fadein').addClass('loading').html('');
      }
    }).done(function( data ) {
    
      if(blockZone == 'picture') {
        blockEl.html(data);
      } else {
        blockEl.html('<div class="wrap">'+data+'</div>');
      }
      
      setTimeout(function()  {
        blockEl.removeClass('loading');
        blockEl.addClass('fadein');
      }, 200);
    });
  }

  $('#date').on('keypress', function(event) {
    event.stopPropagation();
    if (event.keyCode == 13) {
      submitDate();
      return false;
    }
  });

  $('#date').click(function(event) {
    event.stopPropagation();
  });

  $('#submit').click(function(event) {
    event.stopPropagation();
    submitDate();
  });
  
  $('#gobox').click(function(){
    $('#overlay').fadeIn(500);
    $('#prompt').removeClass('hide');
  });
  
  $('#overlay').click(function(){
    $('#prompt').addClass('hide');
    $('#overlay').fadeOut(500);
  });
  
  function submitDate() {
    var txtVal =  $('#date').val();
    if(isDate(txtVal)) {
      var txtVal =  $('#date').val();
      $('#gobox span.date').html(txtVal);
      $('#prompt').addClass('hide');
      $('#overlay').fadeOut(500);
      getBlocks(txtVal);
    } else {
      $('#date').fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);
    }
  }
  
  $('#prompt').removeClass('hide');
  
  function isDate(txtDate)
  {
    var currVal = txtDate;
    if(currVal == '')
      return false;
    

    var rxDatePattern = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{2,4})$/; 
    var dtArray = currVal.match(rxDatePattern); // is format OK?

    if (dtArray == null)
       return false;

    dtDay   = ("00" + dtArray[1]).substr(-2,2);
    dtMonth = ("00" + dtArray[3]).substr(-2,2);
    dtYear  = ("19" + dtArray[5]).substr(-4,4);
    
    $('#date').val(dtDay+'/'+dtMonth+'/'+dtYear);

    if (dtMonth < 1 || dtMonth > 12)
        return false;
    else if (dtDay < 1 || dtDay> 31)
        return false;
    else if ((dtMonth==4 || dtMonth==6 || dtMonth==9 || dtMonth==11) && dtDay ==31)
        return false;
    else if (dtMonth == 2)
    {
       var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
       if (dtDay> 29 || (dtDay ==29 && !isleap))
            return false;
    }
    return true;
  }
  
});