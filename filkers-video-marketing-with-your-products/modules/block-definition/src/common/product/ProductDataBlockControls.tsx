// @ts-ignore
import {__experimentalUnitControl as UnitControl, PanelBody, RangeControl, SelectControl, TextControl, ToggleControl, ToolbarButton} from '@wordpress/components';

import React, {useCallback} from "react";
import {__} from '@wordpress/i18n';
import {InspectorControls} from '@wordpress/block-editor';
import PlaybackControls from "../controls/PlaybackControls";
import ClickControls from "../controls/ClickControls";
import {FilkersBlockEditProps} from "../AbstractFilkersBlock";
import {ProductDataBlockAttrs} from "./ProductDataBlock";
import LayoutControls from "../controls/LayoutControls";
import UidControl from "../controls/UidControl";
import DesignService from "@filkers-wordpress/services/build/design/DesignService";


export interface ProductDataControlsProps extends FilkersBlockEditProps<ProductDataBlockAttrs> {
}

const ProductDataControls = (props: ProductDataControlsProps) => {

    const {attributes, setAttributes} = props;
    const {children, ...propagatedProps} = props;
    const {layout_type} = attributes;

    const uidValidator = useCallback((uid: string) => {
        return DesignService.fetchDesign(uid)
            .then((design) => {
                setAttributes({uid_aspect_ratio: design.aspectRatio});
                return undefined;
            })
            .catch(err => {
                setAttributes({uid_aspect_ratio: 1});
                throw err;
            });
    }, [setAttributes]);

    return (
        <InspectorControls>
            {children}
            <PanelBody title={__('Content settings',)}>
                <UidControl
                    {...propagatedProps}
                    uidValidator={uidValidator}
                    placeholder={__('Paste design UID here')}
                    uidHelpLink="https://www.filkers.com/filkers-product-grid/"
                />
                <LayoutControls {...propagatedProps} />
            </PanelBody>

            <PanelBody title={__('Playback settings')}>
                <PlaybackControls {...propagatedProps} />
            </PanelBody>

            <PanelBody title={__('Click settings')}>
                <ClickControls {...propagatedProps} />
            </PanelBody>

        </InspectorControls>
    );


}

export default ProductDataControls;