import ServerSideRender from "@wordpress/server-side-render";
import {ColorPaletteControl, InspectorControls, LineHeightControl, useBlockProps} from "@wordpress/block-editor";
import {Disabled, FontSizePicker, PanelBody, SelectControl, TextControl, ToggleControl} from "@wordpress/components";
import {registerBlockType} from '@wordpress/blocks';
import {__} from "@wordpress/i18n";
import icons from "../../icons";
import metadata from './block.json';

registerBlockType(metadata, {
    icon: icons.dates,
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
                        block="smartarchiveindexer/dates"
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
                            label={__('Years', 'smartarchiveindexer')}
                            value={attributes.year}
                            options={[
                                {label: __('Show', 'smartarchiveindexer'), value: 'show'},
                                {label: __('Hide', 'smartarchiveindexer'), value: 'hide'}
                            ]}
                            onChange={(value) => setAttributes({year: value})}
                        />
                        <SelectControl
                            label={__('Months', 'smartarchiveindexer')}
                            value={attributes.month}
                            options={[
                                {label: __('Auto', 'smartarchiveindexer'), value: 'auto'},
                                {label: __('Number only', 'smartarchiveindexer'), value: 'number'}
                            ]}
                            onChange={(value) => setAttributes({month: value})}
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
                            label={__('Show Year Counts', 'smartarchiveindexer')}
                            checked={attributes.showYearCounts}
                            onChange={(value) => setAttributes({showYearCounts: value})}
                        />
                        <ToggleControl
                            label={__('Show Month Counts', 'smartarchiveindexer')}
                            checked={attributes.showMonthCounts}
                            onChange={(value) => setAttributes({showMonthCounts: value})}
                        />
                        <ToggleControl
                            label={__('Show Day Counts', 'smartarchiveindexer')}
                            checked={attributes.showDayCounts}
                            onChange={(value) => setAttributes({showDayCounts: value})}
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
                            label={__('Years Background', 'smartarchiveindexer')}
                            value={attributes.varYearBackground}
                            onChange={(value) => setAttributes({varYearBackground: value})}
                        />
                        <ColorPaletteControl
                            label={__('Years Text', 'smartarchiveindexer')}
                            value={attributes.varYearColor}
                            onChange={(value) => setAttributes({varYearColor: value})}
                        />
                        <ColorPaletteControl
                            label={__('Months Background', 'smartarchiveindexer')}
                            value={attributes.varMonthBackground}
                            onChange={(value) => setAttributes({varMonthBackground: value})}
                        />
                        <ColorPaletteControl
                            label={__('Months Text', 'smartarchiveindexer')}
                            value={attributes.varMonthColor}
                            onChange={(value) => setAttributes({varMonthColor: value})}
                        />
                        <ColorPaletteControl
                            label={__('Days Background', 'smartarchiveindexer')}
                            value={attributes.varDayBackground}
                            onChange={(value) => setAttributes({varDayBackground: value})}
                        />
                        <ColorPaletteControl
                            label={__('Days Text', 'smartarchiveindexer')}
                            value={attributes.varDayColor}
                            onChange={(value) => setAttributes({varDayColor: value})}
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
    save: () => {
        return null
    }
});
