const installCE = require('document-register-element/pony');
// by default, the second argument is 'auto'
// but it could be also 'force'
// which ignores feature detection and force
// the polyfill version of CustomElements
installCE(global, 'force');

// import 'document-register-element'
// import '@webcomponents/custom-elements/src/native-shim'
