$(function() {
    var isOpera = !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;
    var isChrome = !!window.chrome && !isOpera;
    var isExplorer =
        typeof document !== 'undefined' && !!document.documentMode && !isEdge;
    var isFirefox = typeof window.InstallTrigger !== 'undefined';
    var isSafari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent);

    if (isChrome) {
        $('html').addClass('is-chrome');
    } else if (isSafari) {
        $('html').addClass('is-safari');
    } else if (isFirefox) {
        $('html').addClass('is-firefox');
    } else {
    }
});
