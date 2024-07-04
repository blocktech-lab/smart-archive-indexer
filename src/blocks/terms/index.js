import ServerSideRender from '@wordpress/server-side-render';
import {ColorPaletteControl, InspectorControls, LineHeightControl, useBlockProps} from "@wordpress/block-editor";
import {Disabled, FontSizePicker, PanelBody, RangeControl, SelectControl, TextControl, ToggleControl} from "@wordpress/components";
import {registerBlockType} from '@wordpress/blocks';
import {__} from "@wordpress/i18n";
import icons from "../../icons";
import metadata from './block.json';

registerBlockType(metadata, {
    icon: icons.terms,
    edit: ({attributes, setAttributes}) => {
        const fontSizes = [
            {
                name: __('Small', 'smartarchiveindexer'),
                slug: 'small',
                size: 12,
            },
            {
                name: __('Normal', 'smartarchiveindexer'),
                slug: 'normal',
                size: 16,
            },
            {
                name: __('Big', 'smartarchiveindexer'),
                slug: 'big',
                size: 20,
            }
        ];

        return (
            <div {...useBlockProps()}>
                <Disabled>
                    <ServerSideRender
                        block="smartarchiveindexer/terms"
                        attributes={attributes}
                    />
                </Disabled>
                <InspectorControls key="settings">
                    <PanelBody title={__('Display', 'smartarchiveindexer')}>
                        <SelectControl
                            label={__('Layout', 'smartarchiveindexer')}
                            value={attributes.layout}
                            options={[
                                {label: __('Basic', 'smartarchiveindexer'), value: 'basic'},
                                {label: __('Compact', 'smartarchiveindexer'), value: 'compact'}
                            ]}
                            onChange={(value) => setAttributes({layout: value})}
                        />
                        <SelectControl
                            label={__('Taxonomy', 'smartarchiveindexer')}
                            value={attributes.taxonomy}
                            options={smartarchiveindexer.taxonomies}
                            onChange={(value) => setAttributes({taxonomy: value})}
                        />
                        <RangeControl
                            label={__('Columns', 'smartarchiveindexer')}
                            value={attributes.columns}
                            onChange={(value) => setAttributes({columns: value})}
                            min={1}
                            max={6}
                            allowReset
                            resetFallbackValue={3}
                            step={1}
                            withInputField={true}
                            separatorType="none"
                            isShiftStepEnabled
                        />
                    </PanelBody>
                    <PanelBody title={__('Data', 'smartarchiveindexer')}>
                        <SelectControl
                            label={__('Post Type', 'smartarchiveindexer')}
                            value={attributes.postType}
                            options={smartarchiveindexer.post_types}
                            onChange={(value) => setAttributes({postType: value})}
                        />
                        <SelectControl
                            label={__('Order By', 'smartarchiveindexer')}
                            value={attributes.orderBy}
                            options={[
                                {label: __("ID"), value: 'id'},
                                {label: __("Name"), value: 'name'},
                                {label: __("Slug"), value: 'slug'},
                                {label: __("Email"), value: 'email'},
                                {label: __("Posts"), value: 'posts'}
                            ]}
                            onChange={(value) => setAttributes({orderBy: value})}
                        />
                        <SelectControl
                            label={__('Order', 'smartarchiveindexer')}
                            value={attributes.order}
                            options={[
                                {label: __('Ascending', 'smartarchiveindexer'), value: 'asc'},
                                {label: __('Descending', 'smartarchiveindexer'), value: 'desc'}
                            ]}
                            onChange={(value) => setAttributes({order: value})}
                        />
                    </PanelBody>
                    <PanelBody title={__('Posts Counts', 'smartarchiveindexer')}>
                        <ToggleControl
                            label={__('Show Counts', 'smartarchiveindexer')}
                            checked={attributes.showCounts}
                            onChange={(value) => setAttributes({showCounts: value})}
                        />
                    </PanelBody>
                    <PanelBody title={__('Typography', 'smartarchiveindexer')}>
                        <FontSizePicker
                            label={__('Font Size', 'smartarchiveindexer')}
                            value={attributes.varFontSize}
                            onChange={(value) => setAttributes({varFontSize: value})}
                            fallBackFontSize={16}
                            fontSizes={fontSizes}
                        />
                        <LineHeightControl
                            label={__('Line Height', 'smartarchiveindexer')}
                            value={attributes.varLineHeight}
                            onChange={(value) => setAttributes({varLineHeight: value})}
                        />
                    </PanelBody>
                    <PanelBody title={__('Colors', 'smartarchiveindexer')}>
                        <ColorPaletteControl
                            label={__('Background', 'smartarchiveindexer')}
                            value={attributes.varBackground}
                            onChange={(value) => setAttributes({varBackground: value})}
                        />
                        <ColorPaletteControl
                            label={__('Text', 'smartarchiveindexer')}
                            value={attributes.varColor}
                            onChange={(value) => setAttributes({varColor: value})}
                        />
                    </PanelBody>
                    <PanelBody title={__('Advanced', 'smartarchiveindexer')}>
                        <TextControl
                            label={__("Additional CSS Class", "smartarchiveindexer")}
                            value={attributes.class}
                            onChange={(value) => setAttributes({class: value})}
                        />
                    </PanelBody>
                </InspectorControls>
            </div>
        )
    },
    save() {
        return null
    }
});
