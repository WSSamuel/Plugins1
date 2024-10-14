import React, { useState } from "react";
import { SelectControl, TextControl, ToggleControl } from "@wordpress/components";
import { __ } from "@wordpress/i18n";
import { useDebounceEffect } from "ahooks";
export const CLICK_CONTROLS_ATTRS = {
    "click_target": { type: "string", default: "_top" },
    "click_href": { type: "string", default: "" },
    "click_behavior": { type: "string", default: "default" },
};
const ClickControls = ({ children, attributes, setAttributes }) => {
    const { click_target, click_href, click_behavior } = attributes;
    // Ponemos un debouncer en custom HREF para evitar que "parpadee"
    // el preview cada vez que pulsamos una tecla
    const [customHref, setCustomHref] = useState(click_href);
    useDebounceEffect(() => {
        setAttributes({ click_href: customHref });
    }, [customHref], { wait: 1000 });
    return (React.createElement(React.Fragment, null,
        React.createElement(ToggleControl, { label: __('Open links in a new tab'), checked: click_target === "_blank", onChange: checked => setAttributes({ click_target: checked === true ? "_blank" : "_top" }) }),
        React.createElement(SelectControl, { label: __('Click behaviour'), value: click_behavior, onChange: (value) => setAttributes({ click_behavior: value }), options: [
                { label: 'Default', value: 'default' },
                { label: 'Do nothing', value: 'none' },
                { label: 'Go to a custom URL', value: 'custom_href' }
            ] }),
        click_behavior === "custom_href" ? (React.createElement(TextControl, { label: __('Custom URL'), placeholder: __('https://your-target-url-here.com'), type: "url", value: customHref, onChange: (customHref) => setCustomHref(customHref) })) : null,
        children));
};
export default ClickControls;
