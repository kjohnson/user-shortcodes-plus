var userShortcodesPlusCompleter = {
    name: 'shortcodes',
    triggerPrefix: '[',
    options: window.userShortcodesPlus,
    getOptionKeywords: function( option ) {
        var labelWords = option.label.split( /\s+/ );
        return [ option.tag ].concat( labelWords );
    },
    getOptionLabel: function( option ) {
        return option.label;
    },
    getOptionCompletion: function( option ) {
        return wp.element.createElement(
            'options',
            { title: option.label },
            '[' + option.tag + ']'
        );
    },
};

 
wp.hooks.addFilter(
    'editor.Autocomplete.completers',
    'user-shortcodes-plus/autocompleters/shortcodes',
    function ( completers, blockName ) {
        return completers.concat( userShortcodesPlusCompleter );
    }
);