jQuery(function($){
"use strict";
var arrayName		= [ vabfwc_local.selectformname ],
		arrayTag		= ['','h1','h2','h3','h4','h5','h6','div','p','center'],
		vabfwcPhoto	= wp.element.createElement('svg',
										{ role:'img', width:"24.000000pt", height:"24.000000pt", viewBox:"0 0 24.000000 24.000000" },
										wp.element.createElement( 'g',
											{ transform:'translate(0.000000,24.000000) scale(0.100000,-0.100000)', fill:'#008B8B', stroke:'none' },
											wp.element.createElement( 'path',
												{ d: 'M102 212 c-12 -2 -34 -14 -48 -27 -20 -19 -24 -31 -22 -64 1 -25 9 -48 20 -58 10 -9 18 -13 18 -10 0 4 9 -2 20 -13 16 -16 24 -18 50 -9 28 10 43 39 20 39 -10 0 -9 35 2 46 14 13 -6 34 -33 34 -33 0 -38 19 -10 37 22 14 33 5 46 -36 6 -18 9 -21 16 -10 6 9 7 1 4 -23 -3 -29 0 -38 10 -38 23 0 20 83 -2 102 -26 21 -65 34 -91 30z m23 -102 c3 -5 1 -10 -4 -10 -6 0 -11 5 -11 10 0 6 2 10 4 10 3 0 8 -4 11 -10z' }
											)
										)
									);
$('#vabfwc_name_form').find('label span').each(function(){
    let idForm = $(this).closest('label').prev('input').attr('data-id'),
				thishtml = $(this).html() !== '' ? $(this).html() : vabfwc_local.selectformname + ' ' + idForm + ' ' + vabfwc_local.emptyformname,
				value =  idForm + '|' + thishtml ;
    arrayName.push( value );
});
function idAttribute(value, name) {
    var idForm = value;
    let nameForm = name;
    arrayName.map(function(value) {
        let id = value;
        let arrayNamePlusID = '';
        if ( value.match(/\|/g) ) {
            arrayNamePlusID = value.split('|');
            id = arrayNamePlusID[1];
        }
        if ( id == nameForm ){
            idForm = arrayNamePlusID[0];
        }
    });
    return idForm;
}
( function( blocks, element ) {
    const el = element.createElement;
    const { registerBlockType } = blocks;
    registerBlockType( 'vabfwc-form/custom-block', {
        title: 'Forms with chart from VAB',
				icon: vabfwcPhoto,/* chart-pie */
				category:'vabfwc_category',
        keywords: [ 'email', 'subscribe', 'misha' ],
        attributes: {
            nameform: {
				type: 'string',
				default: vabfwc_local.selectformname
			},
			form_id: {
				type: 'string',
				default: ''
			},
			form_class: {
				type: 'string',
				default: ''
			},
			id: {
				type: 'string',
				default: ''
			}
		},
		edit: function( props ) {
			const { attributes: { nameform, form_id, form_class, id  }, className, setAttributes } = props;
            return (
                el( 'div', { className: props.className },
                    el( 'div', { className: 'swap-add-vabfwc-form' },
											el( 'div', { className: 'heading-add-vabfwc-form' }, 'Forms with chart from VAB'),
											el( 'div', { className: 'block-add-vabfwc-form name-vabfwc-form' },
												el( 'div', { className: 'text-add-vabfwc-form' }, vabfwc_local.selectform ),
												el( 'div', { className: 'swap-select-vabfwc-form' },
													el( 'select', {  className: 'select-add-vabfwc-form', 'value':props.attributes.nameform,  onChange: function(value) { props.setAttributes({ nameform: event.target.value }) }, },
														arrayName.map(function( valueThis ) {
															let optionText = valueThis;
															if ( valueThis.match(/\|/g) ) {
																valueThis = valueThis.split('|');
																optionText = valueThis[1];
															}
															return el( 'option', {value: optionText}, optionText  );
														})
													)
												)
											),
											el( 'div', { className: 'block-add-vabfwc-form button-text-vabfwc-form' },
												el( 'div', { className: 'text-add-vabfwc-form' }, vabfwc_local.idtoform ),
												el( 'div', { className: 'swap-select-vabfwc-form' },
													el( 'input', { placeholder: vabfwc_local.textforid, 'size':44, 'value':props.attributes.form_id, type: 'text' , className: 'select-add-vabfwc-form' ,
														onChange:  function(value) {
															props.setAttributes({ form_id: event.target.value });
														}
													})
												)
											),
											el( 'div', { className: 'block-add-vabfwc-form button-text-vabfwc-form' },
												el( 'div', { className: 'text-add-vabfwc-form' }, vabfwc_local.classtoform ),
												el( 'div', { className: 'swap-select-vabfwc-form' },
													el( 'input', { placeholder: vabfwc_local.textforclass, 'size':44, 'value':props.attributes.form_class, type: 'text' , className: 'select-add-vabfwc-form' ,
														onChange:  function(value) {
															props.setAttributes({ form_class: event.target.value });
														}
													})
												)
											),
											el( 'div', { className: 'block-add-vabfwc-form' },
												el( 'input', {
													placeholder: '',
													'value': idAttribute(props.attributes.id, props.attributes.nameform ), type: 'hidden' , className: 'select-add-vabfwc-form' },
													props.setAttributes({ id: idAttribute(props.attributes.id, props.attributes.nameform ) })
												)
											),
                    )
                )
            );

        },
        save: function( props ) {
            let nameForm = props.attributes.nameform ;
            let form_id = props.attributes.form_id;
            let form_class = props.attributes.form_class;
            let idForm = idAttribute(props.attributes.id, props.attributes.nameform );
            let string ='[VABFWC id="'+idForm+'" form_id="'+form_id+'" form_class="'+form_class+'" ]';
            return (
                el( 'div', { className: props.className }, string
                )
            );
        },
    });
})
(
	window.wp.blocks,
	window.wp.element
);
////////////////////////////////////////////
( function( blocks, element ) {
    const el = element.createElement;
    const { registerBlockType } = blocks;
    registerBlockType( 'vabfwc-chart/custom-block', {
        title: vabfwc_local.chartsshort,
				icon: vabfwcPhoto,
				category:'vabfwc_category',
        keywords: [ 'email', 'subscribe', 'misha' ],
        attributes: {
            nameform: {
				type: 'string',
				default: vabfwc_local.selectformname
			},
			form_title: {
				type: 'string',
				default: ''
			},
			form_tag: {
				type: 'string',
				default: ''
			},
			form_class: {
				type: 'string',
				default: ''
			},
			id: {
				type: 'string',
				default: ''
			}
		},
		edit: function( props ) {
			const { attributes: { nameform, form_title, form_tag, form_class, id  }, className, setAttributes } = props;
            return (
                el( 'div', { className: props.className },
                    el( 'div', { className: 'swap-add-vabfwc-form' },
											el( 'div', { className: 'heading-add-vabfwc-form' }, vabfwc_local.chartsshort ),
											el( 'div', { className: 'block-add-vabfwc-form name-vabfwc-form' },
												el( 'div', { className: 'text-add-vabfwc-form' }, vabfwc_local.selectform ),
												el( 'div', { className: 'swap-select-vabfwc-form' },
													el( 'select', {  className: 'select-add-vabfwc-form', 'value':props.attributes.nameform,  onChange: function(value) { props.setAttributes({ nameform: event.target.value }) }, },
														arrayName.map(function( valueThis ) {
															let optionText = valueThis;
															if ( valueThis.match(/\|/g) ) {
																valueThis = valueThis.split('|');
																optionText = valueThis[1];
															}
															return el( 'option', {value: optionText}, optionText  );
														})
													)
												)
											),
											el( 'div', { className: 'block-add-vabfwc-form button-text-vabfwc-form' },
												el( 'div', { className: 'text-add-vabfwc-form' }, vabfwc_local.formtitle ),
												el( 'div', { className: 'swap-select-vabfwc-form' },
													el( 'input', { placeholder: vabfwc_local.textfortitle, 'size':44, 'value':props.attributes.form_title, type: 'text' , className: 'select-add-vabfwc-form' ,
														onChange:  function(value) {
															props.setAttributes({ form_title: event.target.value });
														}
													})
												)
											),
											el( 'div', { className: 'block-add-vabfwc-form button-text-vabfwc-form' },
												el( 'div', { className: 'text-add-vabfwc-form' }, vabfwc_local.formtag ),
												el( 'div', { className: 'swap-select-vabfwc-form' },
													el( 'select', {  className: 'select-add-vabfwc-form', 'value':props.attributes.form_tag,  onChange: function(value) { props.setAttributes({ form_tag: event.target.value }) }, },
														arrayTag.map(function( valueThis ) {
															let optionText = valueThis;
															if ( valueThis.match(/\|/g) ) {
																valueThis = valueThis.split('|');
																optionText = valueThis[1];
															}
															return el( 'option', {value: optionText}, optionText  );
														})
													)
												)
											),
											el( 'div', { className: 'block-add-vabfwc-form button-text-vabfwc-form' },
												el( 'div', { className: 'text-add-vabfwc-form' }, vabfwc_local.classtotag ),
												el( 'div', { className: 'swap-select-vabfwc-form' },
													el( 'input', { placeholder: vabfwc_local.textclassfortag, 'size':44, 'value':props.attributes.form_class, type: 'text' , className: 'select-add-vabfwc-form',
														onChange:  function(value) {
															props.setAttributes({ form_class: event.target.value });
														}
													})
												)
											),
											el( 'div', { className: 'block-add-vabfwc-form' },
												el( 'input', {
													placeholder: '',
													'value': idAttribute(props.attributes.id, props.attributes.nameform ), type: 'hidden' , className: 'select-add-vabfwc-form' },
													props.setAttributes({ id: idAttribute(props.attributes.id, props.attributes.nameform ) })
												)
											),
                    )
                )
            );

        },
        save: function( props ) {
            let nameForm = props.attributes.nameform ;
            let form_title = props.attributes.form_title;
            let form_tag = props.attributes.form_tag;
            let form_class = props.attributes.form_class;
            let idForm = idAttribute(props.attributes.id, props.attributes.nameform );
            let string ='[VABFWC_Graphic id="'+idForm+'" title="'+form_title+'" tag="'+form_tag+'" class="'+form_class+'" ]';
            return (
                el( 'div', { className: props.className }, string
                )
            );
        },
    });
})
(
	window.wp.blocks,
	window.wp.element
);
wp.blocks.updateCategory( 'vabfwc_category', { icon: vabfwcPhoto } );
});