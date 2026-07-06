import {
    InnerBlocks,
    InspectorControls,
    useBlockProps,
} from "@wordpress/block-editor";
import { PanelBody, RangeControl } from "@wordpress/components";
import "./editor.scss";

export default function Edit({ attributes, setAttributes }) {
    const { borderRadius, gap } = attributes;

    const TEMPLATE = [
        ["hero-section-wizard/hero-section-secondary-child"],
        ["hero-section-wizard/hero-section-secondary-child"],
        ["hero-section-wizard/hero-section-secondary-child"],
    ];

    const blockProps = useBlockProps({
        style: {
            "--hero-section-secondary-container-border-radius":
                borderRadius + "px",
            "--hero-section-secondary-container-gap": gap + "em",
        },
    });

    return (
        <>
            <InspectorControls>
                <PanelBody title="Container Settings" initialOpen={true}>
                    <RangeControl
                        label="Border Radius (px)"
                        value={borderRadius || 0}
                        onChange={(value) =>
                            setAttributes({ borderRadius: value })
                        }
                        min={0}
                        max={100}
                        step={1}
                    />
                    <RangeControl
                        label="Gap (em)"
                        value={gap || 1}
                        onChange={(value) => setAttributes({ gap: value })}
                        min={0}
                        max={100}
                        step={0.2}
                    />
                </PanelBody>
            </InspectorControls>
            <section {...blockProps}>
                <InnerBlocks template={TEMPLATE} templateLock="all" />
            </section>
        </>
    );
}
