import React, {useState} from "react";
import {__} from "@wordpress/i18n";
import AbstractFilkersBlock, {FilkersBlockAttributesMap} from "../AbstractFilkersBlock";
import {AbstractControlProps} from "./AbstractControls";

// @ts-ignore
import {__experimentalInputControl as InputControl} from "@wordpress/components";
import {useDebounceEffect} from "ahooks";


export const UID_CONTROLS_ATTRS: FilkersBlockAttributesMap = {
    "uid": {type: "string", default: ""},
    "uid_aspect_ratio": {type: "number", default: 0.8}
}

export interface UidControlAttrs {
    uid: string,
    uid_aspect_ratio: number
}

export interface UidControlProps<B extends AbstractFilkersBlock> extends AbstractControlProps<UidControlAttrs, B> {
    placeholder: string,
    uidValidator?: (uid) => Promise<void>,
    onUidSubmit?: (uid) => any,
    uidHelpLink?:string
}

const UidControl = <B extends AbstractFilkersBlock>(props: UidControlProps<B>) => {

    const {attributes, setAttributes, placeholder, uidValidator, onUidSubmit, uidHelpLink, block} = props;

    const {uid} = attributes;
    const [inputUid, setInputUid] = useState<string>(uid);
    const [errorMessage, setErrorMessage] = useState(undefined);

    useDebounceEffect(() => {
        if (inputUid !== undefined && inputUid !== null) {
            const effectiveUid = inputUid.trim();
            if (effectiveUid == '') {
                return;
            }

            if (uidValidator === undefined) {
                setErrorMessage('');
                setAttributes({uid: effectiveUid})
                if (onUidSubmit !== undefined) {
                    onUidSubmit(inputUid);
                }
            } else {
                uidValidator(effectiveUid)
                    .then(() => {
                        setErrorMessage('');
                        setAttributes({uid: effectiveUid})
                        if (onUidSubmit !== undefined) {
                            onUidSubmit(effectiveUid);
                        }
                    })
                    .catch(err => {
                        setErrorMessage(`${err}`);
                    })
            }
        }
    }, [inputUid, uidValidator, onUidSubmit], {wait: 250});

    return (
        <div className="components-base-control block-editor-filkers-folder-player__column filkers-input-uid">
            <div className="block-editor-filkers-blocks__row">
                <label>
                    {__("UID to embed")}
                </label>
                <a href={uidHelpLink} target="_blank">{__('What is this?',)}</a>
            </div>
            <input
                type="text"
                value={inputUid || ''}
                className="components-placeholder__input"
                placeholder={placeholder}
                onChange={(event) => setInputUid(event.target.value)}
            />
            <div className="filkers-input-error">
                {errorMessage}
            </div>
        </div>
    );
}

export default UidControl;