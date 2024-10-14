import React, {Dispatch, ReactNode, SetStateAction, useCallback, useState} from "react";
import {BlockEditProps} from "@wordpress/blocks";
import {DesignRelatedBlockAttrs} from "./DesignRelatedBlock";
import {BlockIcon, useBlockProps} from '@wordpress/block-editor';
import {View} from "@wordpress/primitives";
import {Button, Placeholder} from "@wordpress/components";
import {__} from "@wordpress/i18n";
import DesignService from "@filkers-wordpress/services/build/design/DesignService";

// @ts-ignore
import ServerSideRender from '@wordpress/server-side-render';


export interface DesignRelatedBlockEditProps<ATTRS extends DesignRelatedBlockAttrs> extends BlockEditProps<ATTRS> {
    blockName: string,
    blockTitle: string,
    icon: ReactNode,
    showEditor: boolean,
    onShowEditorChange: (value: boolean) => any,
    children?: ReactNode | ReactNode[];
}

export const useShowEditor = (uid: string): [boolean, Dispatch<SetStateAction<boolean>>] => {
    return useState<boolean>(uid === undefined || uid === null || uid.trim() === "");
};


const DesignRelatedBlockEdit = <ATTRS extends DesignRelatedBlockAttrs>(props: DesignRelatedBlockEditProps<ATTRS>) => {

    const {attributes, showEditor, onShowEditorChange, icon, blockName, blockTitle, children, setAttributes} = props;
    const {uid} = attributes;

    const placeHolder = __('Paste your design UID here…');


    const blockProps = useBlockProps();

    const [inputUid, setInputUid] = useState<string>(attributes?.uid);
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
                setAttributes({uid: inputUid, aspectRatio: design?.aspectRatio} as Partial<ATTRS>);
                onShowEditorChange(false);
                setErrorMessage(undefined);
            })
            .catch(err => {
                setErrorMessage(`${err}`);
                setAttributes({aspectRatio: 1} as Partial<ATTRS>);
            });

        return false;
    }, [inputUid, setAttributes, onShowEditorChange, setErrorMessage]);

    return (
        <View {...blockProps}>
            {children}
            {showEditor === true ? (
                <Placeholder
                    icon={<BlockIcon icon={icon} showColors/>}
                    label={blockTitle}
                    className="wp-block-embed"
                    //@ts-ignore
                    instructions={errorMessage === undefined ? placeHolder :
                        <span className="block-editor-filkers-folder-player__error">{errorMessage}</span>}
                >
                    <input
                        type="text"
                        value={inputUid || ''}
                        className="components-placeholder__input filkers-input-uid"
                        aria-label={blockTitle}
                        placeholder={placeHolder}
                        onChange={uidChangeHandler}
                    />
                    <Button isPrimary type="button" onClick={uidSubmitHandler}>
                        {__('Embed')}
                    </Button>
                </Placeholder>
            ) : (
                <ServerSideRender
                    key={JSON.stringify(attributes)}
                    block={blockName}
                    attributes={{...props.attributes, preview: true}}
                />
            )}
        </View>
    );
}

export default DesignRelatedBlockEdit