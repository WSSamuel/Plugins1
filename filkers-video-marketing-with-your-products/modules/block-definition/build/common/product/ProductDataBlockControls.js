// @ts-ignore
import { PanelBody } from '@wordpress/components';
import React, { useCallback } from "react";
import { __ } from '@wordpress/i18n';
import { InspectorControls } from '@wordpress/block-editor';
import PlaybackControls from "../controls/PlaybackControls";
import ClickControls from "../controls/ClickControls";
import LayoutControls from "../controls/LayoutControls";
import UidControl from "../controls/UidControl";
import DesignService from "@filkers-wordpress/services/build/design/DesignService";
const ProductDataControls = (props) => {
    const { attributes, setAttributes } = props;
    const { children, ...propagatedProps } = props;
    const { layout_type } = attributes;
    const uidValidator = useCallback((uid) => {
        return DesignService.fetchDesign(uid)
            .then((design) => {
            setAttributes({ uid_aspect_ratio: design.aspectRatio });
            return undefined;
        })
            .catch(err => {
            setAttributes({ uid_aspect_ratio: 1 });
            throw err;
        });
    }, [setAttributes]);
    return (React.createElement(InspectorControls, null,
        children,
        React.createElement(PanelBody, { title: __('Content settings') },
            React.createElement(UidControl, Object.assign({}, propagatedProps, { uidValidator: uidValidator, placeholder: __('Paste design UID here'), uidHelpLink: "https://www.filkers.com/filkers-product-grid/" })),
            React.createElement(LayoutControls, Object.assign({}, propagatedProps))),
        React.createElement(PanelBody, { title: __('Playback settings') },
            React.createElement(PlaybackControls, Object.assign({}, propagatedProps))),
        React.createElement(PanelBody, { title: __('Click settings') },
            React.createElement(ClickControls, Object.assign({}, propagatedProps)))));
};
export default ProductDataControls;
