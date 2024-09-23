wp.domReady(function() {
    var el = wp.element.createElement;
    var Button = wp.components.Button;
    var SVGIcon = el('svg', {
        xmlns: "http://www.w3.org/2000/svg",
        width: "32px",
        height: "32px",
        viewBox: "0 -2 24 24",
        dangerouslySetInnerHTML: {
            __html: '<g stroke="none" stroke-width="1" fill="#ffffff" fill-rule="evenodd"><path class="st0" d="M1.2,20L1.2,20l0-20h7.5v12.5C8.8,16.6,5.4,20,1.2,20z M17.6,4.8L17.6,4.8c0-2.6-2.1-4.8-4.8-4.8H9.6v9.6h3.2 C15.4,9.6,17.6,7.4,17.6,4.8z M18.8,15.2L18.8,15.2c0-2.6-2.1-4.8-4.8-4.8H9.6V20H14C16.6,20,18.8,17.9,18.8,15.2z"/></g>'
        }
    });

    // Register the custom button in the Gutenberg editor
    wp.plugins.registerPlugin('borderless-ai-button', {
        render: function() {
            return el(wp.editPost.PluginPostStatusInfo, {},
                el(Button, {
                    className: 'ai-button',
                    isPrimary: true,
                    onClick: function() {
                        window.open('https://visualmodo.com/artificial-intelligence', '_blank');
                    },
                    icon: SVGIcon
                }, 'Generate with Visualmodo AI')
            );
        }
    });
});
