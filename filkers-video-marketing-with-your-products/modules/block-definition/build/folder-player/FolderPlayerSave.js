import React from "react";
import { useBlockProps } from '@wordpress/block-editor';
const FolderPlayerSave = (props) => {
    const { attributes } = props;
    const { uid, width, height, size, target, clickBehavior, customHref, speed, slider_arrows, slider_random, slider_dots } = attributes;
    const { className = "", ...blockProps } = useBlockProps.save();
    const style = {};
    if (width !== undefined && width !== "") {
        style.width = width;
    }
    if (height !== undefined && height !== "") {
        style.height = height;
    }
    const additionalProperties = {};
    switch (clickBehavior) {
        case "none":
            additionalProperties.href = "none";
            break;
        case "custom_href":
            additionalProperties.href = customHref;
            break;
    }
    return (React.createElement("div", Object.assign({ className: `filkers-folder-player ${className}` }, blockProps),
        React.createElement("filkers-folder", Object.assign({ key: `folder-${uid}-${slider_random}-${size}-${width}-${height}-${speed}-${slider_arrows}-${slider_dots}` }, additionalProperties, { uid: uid, random: slider_random === true ? true : undefined, class: `${size}`, speed: speed, target: target, style: { width, height }, arrows: slider_arrows, dots: slider_dots, noerrors: true }))));
};
export default FolderPlayerSave;
