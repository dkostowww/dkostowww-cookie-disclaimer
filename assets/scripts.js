jQuery(document).ready(function ($) {
    let cookieStatement = params.cookie_disclaimer_cookie_statement === "" ? "We use cookies to give you the best online experience." : params.cookie_disclaimer_cookie_statement;
    let siteOwnership = params.cookie_disclaimer_site_ownership === "" ? 'By using our website, you agree to our <a href="/privacy-policy" target="_blank" class="privacy_policy_link">privacy policy</a>.' : params.cookie_disclaimer_site_ownership;

    let content =
        `<div id="cookie_disclaimer" class="cookie_disclaimer hide_disclaimer">
            <button id="close_button" class="close_button">✕</button>
            <p id="cookie_statement">`+ cookieStatement +`</p>
            <p id="site_ownership">` + siteOwnership + `</p>
            <button id="accept_button" class="accept_button">Accept and Close</button>
        </div>`;

    $(content).prependTo('body');
    showCookieConsent();
    checkStyles();

    $('#close_button').click(function (){
        $('#cookie_disclaimer').addClass('hide_disclaimer');
    })

    $('#accept_button').click(function (){
        setCookie('cookie_consent',"agreed", 7);
        $('#cookie_disclaimer').addClass('hide_disclaimer');
    })

});
function setCookie(name,value,days) {
    let expires = "";
    if (days) {
        let date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}
function getCookie(name) {
    let nameEQ = name + "=";
    let ca = document.cookie.split(';');
    for(let i=0;i < ca.length;i++) {
        let c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}
function showCookieConsent(){
    let banner = $('#cookie_disclaimer');
    if(getCookie('cookie_consent') !== 'agreed'){
        banner.removeClass('hide_disclaimer');
    }
}
function checkStyles(){
    if(params.cookie_disclaimer_color !== ""){
        $('#cookie_disclaimer').css('border-color', params.cookie_disclaimer_color);
        $('#accept_button').css('background-color', params.cookie_disclaimer_color);
    }
    if(params.cookie_disclaimer_width!== ""){
        $('#cookie_disclaimer').css(`width`, params.cookie_disclaimer_width);
    }
    if(params.cookie_disclaimer_font_style!== ""){
        $('#close_button').css('font-style', params.cookie_disclaimer_font_style);
        $('#cookie_statement').css('font-style', params.cookie_disclaimer_font_style);
        $('#site_ownership').css('font-style', params.cookie_disclaimer_font_style);
        $('#accept_button').css('font-style', params.cookie_disclaimer_font_style);
    }
    if(params.cookie_disclaimer_font_family!== ""){
        $('#close_button').css('font-family', params.cookie_disclaimer_font_family);
        $('#cookie_statement').css('font-family', params.cookie_disclaimer_font_family);
        $('#site_ownership').css('font-family', params.cookie_disclaimer_font_family);
        $('#accept_button').css('font-family', params.cookie_disclaimer_font_family);
    }
    if(params.cookie_disclaimer_font_size!== ""){
        $('#close_button').css('font-size', params.cookie_disclaimer_font_size);
        $('#cookie_statement').css('font-size', params.cookie_disclaimer_font_size);
        $('#site_ownership').css('font-size', params.cookie_disclaimer_font_size);
        $('#accept_button').css('font-size', params.cookie_disclaimer_font_size);
    }
    if(params.cookie_disclaimer_line_height!== ""){
        $('#close_button').css('line-height', params.cookie_disclaimer_line_height);
        $('#cookie_statement').css('line-height', params.cookie_disclaimer_line_height);
        $('#site_ownership').css('line-height', params.cookie_disclaimer_line_height);
        $('#accept_button').css('line-height', params.cookie_disclaimer_line_height);
    }
    if(params.cookie_disclaimer_font_weight!== ""){
        $('#close_button').css('font-weight', params.cookie_disclaimer_font_weight);
        $('#cookie_statement').css('font-weight', params.cookie_disclaimer_font_weight);
        $('#site_ownership').css('font-weight', params.cookie_disclaimer_font_weight);
        $('#accept_button').css('font-weight', params.cookie_disclaimer_font_weight);
    }
    if(params.cookie_disclaimer_font_color!== ""){
        $('#close_button').css('color', params.cookie_disclaimer_font_color);
        $('#cookie_statement').css('color', params.cookie_disclaimer_font_color);
        $('#site_ownership').css('color', params.cookie_disclaimer_font_color);
        $('#accept_button').css('color', params.cookie_disclaimer_font_color);
    }
    if(params.cookie_disclaimer_letter_spacing!== ""){
        $('#close_button').css('letter-spacing', params.cookie_disclaimer_letter_spacing);
        $('#cookie_statement').css('letter-spacing', params.cookie_disclaimer_letter_spacing);
        $('#site_ownership').css('letter-spacing', params.cookie_disclaimer_letter_spacing);
        $('#accept_button').css('letter-spacing', params.cookie_disclaimer_letter_spacing);
    }
}