/**
 * Media Block Widget
 */
jQuery(document).ready(function($) {

    // --------------------------------------------------------------- //
    // Media uploader                                                  //
    // --------------------------------------------------------------- //
    // Opens WordPress media uploader in order to add an               //
    // image to a Media Block instance.                                //
    // --------------------------------------------------------------- //
    // 
    $(document).on("click", "#upload_image_button", function() {

        $.data(document.body, 'prevElement', $(this).prev());

        window.send_to_editor = function(html) {
            var imgurl = $(html).attr('src');
            var inputText = $.data(document.body, 'prevElement');

            if(inputText != undefined && inputText != '')
            {
                inputText.val(imgurl);
            }

            tb_remove();
        };

        tb_show('', 'media-upload.php?type=image&TB_iframe=true');
        return false;
    });

    // --------------------------------------------------------------- //
    // JQuery-UI Datepicker                                            //
    // --------------------------------------------------------------- //
    // Add a datepicker to the Media Block widget if the               //
    // `add_datepicker` option is checked.                                              //
    // --------------------------------------------------------------- //
    // 
    $(function() {
        // The date input inside of `p#media_block_datepicker`
        if ($("#media_block_datepicker").length)
        {
            $("#media_block_datepicker").datepicker(); 
        }           
    });

});