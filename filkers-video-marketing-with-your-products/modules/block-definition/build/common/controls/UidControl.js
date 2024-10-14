import React, { useState } from "react";
import { __ } from "@wordpress/i18n";
import { useDebounceEffect } from "ahooks";
export const UID_CONTROLS_ATTRS = {
    "uid": { type: "string", default: "" },
    "uid_aspect_ratio": { type: "number", default: 0.8 }
};
const UidControl = (props) => {
    const { attributes, setAttributes, placeholder, uidValidator, onUidSubmit, uidHelpLink, block } = props;
    const { uid } = attributes;
    const [inputUid, setInputUid] = useState(uid);
    const [errorMessage, setErrorMessage] = useState(undefined);
    useDebounceEffect(() => {
        if (inputUid !== undefined && inputUid !== null) {
            const effectiveUid = inputUid.trim();
            if (effectiveUid == '') {
                return;
            }
            if (uidValidator === undefined) {
                setErrorMessage('');
                setAttributes({ uid: effectiveUid });
                if (onUidSubmit !== undefined) {
                    onUidSubmit(inputUid);
                }
            }
            else {
                uidValidator(effectiveUid)
                    .then(() => {
                    setErrorMessage('');
                    setAttributes({ uid: effectiveUid });
                    if (onUidSubmit !== undefined) {
                        onUidSubmit(effectiveUid);
                    }
                })
                    .catch(err => {
                    setErrorMessage(`${err}`);
                });
            }
        }
    }, [inputUid, uidValidator, onUidSubmit], { wait: 250 });
    return (React.createElement("div", { className: "components-base-control block-editor-filkers-folder-player__column filkers-input-uid" },
        React.createElement("div", { className: "block-editor-filkers-blocks__row" },
            React.createElement("label", null, __("UID to embed")),
            React.createElement("a", { href: uidHelpLink, target: "_blank" }, __('What is this?'))),
        React.createElement("input", { type: "text", value: inputUid || '', className: "components-placeholder__input", placeholder: placeholder, onChange: (event) => setInputUid(event.target.value) }),
        React.createElement("div", { className: "filkers-input-error" }, errorMessage)));
};
export default UidControl;
