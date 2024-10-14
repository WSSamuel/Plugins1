import React, { useCallback, useState } from "react";
import { Button, Placeholder } from "@wordpress/components";
import { __ } from "@wordpress/i18n";
import { BlockIcon } from '@wordpress/block-editor';
export const UID_CONTROLS_ATTRS = {
    "uid": { type: "string", default: "" },
    "uid_aspect_ratio": { type: "number", default: 1 }
};
const UidPlaceHolder = (props) => {
    const { attributes, setAttributes, placeholder, uidValidator, onUidSubmit, block } = props;
    const { uid } = attributes;
    const [inputUid, setInputUid] = useState(uid);
    const [errorMessage, setErrorMessage] = useState(undefined);
    const uidSubmitHandler = useCallback((event) => {
        if (event?.stopPropagation) {
            event.stopPropagation();
        }
        if (uidValidator === undefined) {
            setErrorMessage('');
            setAttributes({ uid: inputUid });
            if (onUidSubmit !== undefined) {
                onUidSubmit(inputUid);
            }
        }
        else {
            uidValidator(inputUid)
                .then(() => {
                setErrorMessage('');
                setAttributes({ uid: inputUid });
                if (onUidSubmit !== undefined) {
                    onUidSubmit(inputUid);
                }
            })
                .catch(err => {
                setErrorMessage(`${err}`);
            });
        }
    }, [inputUid, uidValidator, onUidSubmit]);
    return (React.createElement(Placeholder, { icon: React.createElement(BlockIcon, { icon: block.getBlockIcon(), showColors: true }), label: block.getBlockTitle(), className: "wp-block-embed", 
        //@ts-ignore
        instructions: errorMessage === undefined ? placeholder :
            React.createElement("span", { className: "block-editor-filkers-blocks__error" }, errorMessage) },
        React.createElement("input", { type: "text", value: inputUid || '', className: "components-placeholder__input filkers-input-uid", "aria-label": placeholder, placeholder: placeholder, onChange: (event) => setInputUid(event.target.value) }),
        React.createElement(Button, { isPrimary: true, type: "button", onClick: uidSubmitHandler }, __('Embed'))));
};
export default UidPlaceHolder;
