//var $jq = jQuery.noConflict();
jQuery(document).ready(function() {
    
    
    /* Accordion
    ================================================== */
    jQuery('.et_pb_toggle_title').click(function(){
        var $toggle = jQuery(this).closest('.et_pb_toggle');
        if (!$toggle.hasClass('et_pb_accordion_toggling')) {
            var $accordion = $toggle.closest('.et_pb_accordion');
            if ($toggle.hasClass('et_pb_toggle_open')) {
                $accordion.addClass('et_pb_accordion_toggling');
                $toggle.find('.et_pb_toggle_content').slideToggle(700, function() { 
                $toggle.removeClass('et_pb_toggle_open').addClass('et_pb_toggle_close');      
                });
            }
            setTimeout(function(){ 
                $accordion.removeClass('et_pb_accordion_toggling'); 
            }, 750);
        }
    });
    jQuery('.et_pb_accordion .et_pb_toggle_open').addClass('et_pb_toggle_close').removeClass('et_pb_toggle_open');
    jQuery('.et_pb_accordion .et_pb_toggle').click(function() {
        $this = $(this);
        setTimeout(function(){
            $this.closest('.et_pb_accordion').removeClass('et_pb_accordion_toggling');
        },700);
    });


    /* Structured data FAQ (Accordion)
    ================================================== */
    var $accordion = jQuery('#faq');
    if ($accordion.length === 0) return;
    var faq_data = [];
    $accordion.find('.et_pb_accordion_item').each(function() {
        var $item = jQuery(this);
        var question = $item.find('.et_pb_toggle_title').text().trim();
        var answer = $item.find('.et_pb_toggle_content').text().trim();
        if (question && answer) {
            faq_data.push({
                "@type": "Question",
                "name": question,
                "acceptedAnswer": {
                "@type": "Answer",
                "text": answer
                }
            });
        }
    });
    if (faq_data.length > 0) {
        var schema = {
            "@context": "https://schema.org",
            "@type": "FAQPage",
            "mainEntity": faq_data
        };
        var script_tag = jQuery('<script>', {
            type: 'application/ld+json',
            text: JSON.stringify(schema)
        });
        jQuery('head').append(script_tag);
    }

});