import React, {useCallback, useState} from "react";
import {Button, Placeholder} from "@wordpress/components";
import {__} from "@wordpress/i18n";
import AbstractFilkersBlock, {FilkersBlockAttributesMap} from "../AbstractFilkersBlock";
import {AbstractControlProps} from "./AbstractControls";
import {BlockIcon} from '@wordpress/block-editor';


export const UID_CONTROLS_ATTRS: FilkersBlockAttributesMap = {
    "uid": {type: "string", default: ""},
    "uid_aspect_ratio": {type: "number", default: 1}
}

export interface UidPlaceHolderAttrs {
    uid: string,
    uid_aspect_ratio: number
}

export interface UidPlaceHolderProps<B extends AbstractFilkersBlock> extends AbstractControlProps<UidPlaceHolderAttrs, B> {
    placeholder: string,
    uidValidator?: (uid) => Promise<void>,
    onUidSubmit?: (uid) => any
}

const UidPlaceHolder = <B extends AbstractFilkersBlock>(props: UidPlaceHolderProps<B>) => {

    const {attributes, setAttributes, placeholder, uidValidator, onUidSubmit, block} = props;

    const {uid} = attributes;
    const [inputUid, setInputUid] = useState<string>(uid);
    const [errorMessage, setErrorMessage] = useState(undefined);

    const uidSubmitHandler = useCallback((event?) => {
        if (event?.stopPropagation) {
            event.stopPropagation();
        }

        if (uidValidator === undefined) {
            setErrorMessage('');
            setAttributes({uid: inputUid})
            if (onUidSubmit !== undefined) {
                onUidSubmit(inputUid);
            }
        } else {
            uidValidator(inputUid)
                .then(() => {
                    setErrorMessage('');
                    setAttributes({uid: inputUid})
                    if (onUidSubmit !== undefined) {
                        onUidSubmit(inputUid);
                    }
                })
                .catch(err => {
                    setErrorMessage(`${err}`);
                })
        }
    }, [inputUid, uidValidator, onUidSubmit]);

    return (
        <Placeholder
            icon={<BlockIcon icon={block.getBlockIcon()} showColors/>}
            label={block.getBlockTitle()}
            className="wp-block-embed"
            //@ts-ignore
            instructions={errorMessage === undefined ? placeholder :
                <span className="block-editor-filkers-blocks__error">{errorMessage}</span>}
        >
            <input
                type="text"
                value={inputUid || ''}
                className="components-placeholder__input filkers-input-uid"
                aria-label={placeholder}
                placeholder={placeholder}
                onChange={(event) => setInputUid(event.target.value)}
            />
            <Button isPrimary type="button" onClick={uidSubmitHandler}>
                {__('Embed')}
            </Button>
        </Placeholder>
    );
}

export default UidPlaceHolder;