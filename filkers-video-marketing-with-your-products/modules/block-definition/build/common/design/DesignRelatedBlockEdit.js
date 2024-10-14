import React, { useCallback, useState } from "react";
import { BlockIcon, useBlockProps } from '@wordpress/block-editor';
import { View } from "@wordpress/primitives";
import { Button, Placeholder } from "@wordpress/components";
import { __ } from "@wordpress/i18n";
import DesignService from "@filkers-wordpress/services/build/design/DesignService";
// @ts-ignore
import ServerSideRender from '@wordpress/server-side-render';
export const useShowEditor = (uid) => {
    return useState(uid === undefined || uid === null || uid.trim() === "");
};
const DesignRelatedBlockEdit = (props) => {
    const { attributes, showEditor, onShowEditorChange, icon, blockName, blockTitle, children, setAttributes } = props;
    const { uid } = attributes;
    const placeHolder = __('Paste your design UID here…');
    const blockProps = useBlockProps();
    const [inputUid, setInputUid] = useState(attributes?.uid);
    const [errorMessage, setErrorMessage] = useState(undefined);
    const uidChangeHandler = useCallback((event) => {
        setInputUid(event.target.value);
    }, [setInputUid]);
    const uidSubmitHandler = useCallback((event) => {
        if (event?.stopPropagation) {
            event.stopPropagation();
        }
        // Validamos el uid
        DesignService
            .fetchDesign(inputUid)
            .then((design) => {
            setAttributes({ uid: inputUid, aspectRatio: design?.aspectRatio });
            onShowEditorChange(false);
            setErrorMessage(undefined);
        })
            .catch(err => {
            setErrorMessage(`${err}`);
            setAttributes({ aspectRatio: 1 });
        });
        return false;
    }, [inputUid, setAttributes, onShowEditorChange, setErrorMessage]);
    return (React.createElement(View, Object.assign({}, blockProps),
        children,
        showEditor === true ? (React.createElement(Placeholder, { icon: React.createElement(BlockIcon, { icon: icon, showColors: true }), label: blockTitle, className: "wp-block-embed", 
            //@ts-ignore
            instructions: errorMessage === undefined ? placeHolder :
                React.createElement("span", { className: "block-editor-filkers-folder-player__error" }, errorMessage) },
            React.createElement("input", { type: "text", value: inputUid || '', className: "components-placeholder__input filkers-input-uid", "aria-label": blockTitle, placeholder: placeHolder, onChange: uidChangeHandler }),
            React.createElement(Button, { isPrimary: true, type: "button", onClick: uidSubmitHandler }, __('Embed')))) : (React.createElement(ServerSideRender, { key: JSON.stringify(attributes), block: blockName, attributes: { ...props.attributes, preview: true } }))));
};
export default DesignRelatedBlockEdit;
