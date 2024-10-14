var RpCheckoutAutocomplete=RpCheckoutAutocomplete||{},RpCheckoutAutocomplete_shipping=RpCheckoutAutocomplete_shipping||{};RpCheckoutAutocomplete.event={},RpCheckoutAutocomplete_shipping.event={},RpCheckoutAutocomplete.method={placeSearch:"",IdSeparator:"",autocomplete:"",streetNumber:"",formFields:{billing_address_1:"",billing_address_2:"",billing_city:"",billing_state:"",billing_postcode:"",billing_country:""},formFieldsValue:{billing_address_1:"",billing_address_2:"",billing_city:"",billing_state:"",billing_postcode:"",billing_country:""},component_form:"",initialize:function(){this.getIdSeparator(),this.initFormFields(),this.autocomplete=new google.maps.places.Autocomplete(document.getElementById("billing_address_1"),{types:["geocode"]}),google.maps.event.addListener(this.autocomplete,"place_changed",function(e){RpCheckoutAutocomplete.method.fillInAddress()});var e=document.getElementById("billing_address_1");null!=e&&e.addEventListener("focus",function(e){RpCheckoutAutocomplete.method.setAutocompleteCountry()},!0);var t=document.getElementById("billing_country");null!=t&&t.addEventListener("change",function(e){RpCheckoutAutocomplete.method.setAutocompleteCountry()},!0)},getIdSeparator:function(){return document.getElementById("billing_address_1")?(this.IdSeparator=":",":"):(this.IdSeparator="_","_")},initFormFields:function(){for(var e in this.formFields)this.formFields[e]=e;this.component_form={street_number:["billing_address_1","short_name"],route:["billing_address_1","long_name"],locality:["billing_city","long_name"],administrative_area_level_1:["billing_state","short_name"],country:["billing_country","long_name"],postal_code:["billing_postcode","short_name"]}},fillInAddress:function(){this.clearFormValues();var e=this.autocomplete.getPlace();this.resetForm();for(var t in e.address_components)for(var n in e.address_components[t].types)for(var o in this.component_form){if(o==e.address_components[t].types[n]){"street_number"==o?this.streetNumber=e.address_components[t].short_name:"FR"==document.getElementById("billing_country").value&&(this.streetNumber=e.address_components[0].short_name,this.streetNumber+=","+e.address_components[1].long_name);var i=this.component_form[o][1];e.address_components[t].hasOwnProperty(i)&&(this.formFieldsValue[this.component_form[o][0]]=e.address_components[t][i])}}this.appendStreetNumber(),this.fillForm(),$=jQuery.noConflict(),$("#billing_state").trigger("change"),"undefined"!=typeof FireCheckout&&checkout.update(checkout.urls.billing_address)},clearFormValues:function(){for(var e in this.formFieldsValue)this.formFieldsValue[e]=""},appendStreetNumber:function(){""!=this.streetNumber&&(this.formFieldsValue.billing_address_1=this.streetNumber+" "+this.formFieldsValue.billing_address_1)},fillForm:function(){for(var e in this.formFieldsValue)if("billing_country"==e)this.selectRegion(e,this.formFieldsValue[e]);else{if(null===document.getElementById(e))continue;document.getElementById(e).value=this.formFieldsValue[e]}},selectRegion:function(e,t){if(null==document.getElementById(e))return!1;for(var n=document.getElementById(e),o=0;o<n.options.length;o++)if(n.options[o].text==t){n.selectedIndex=o;break}},resetForm:function(){null!==document.getElementById("billing_address_2")&&(document.getElementById("billing_address_2").value="")},setAutocompleteCountry:function(){if(null===document.getElementById("billing_country"))e="FR";else var e=document.getElementById("billing_country").value;this.autocomplete.setComponentRestrictions({country:e})}},RpCheckoutAutocomplete_shipping.method={placeSearch:"",IdSeparator:"",autocomplete:"",streetNumber:"",formFields:{shipping_address_1:"",shipping_address_2:"",shipping_city:"",shipping_state:"",shipping_postcode:"",shipping_country:""},formFieldsValue:{shipping_address_1:"",shipping_address_2:"",shipping_city:"",shipping_state:"",shipping_postcode:"",shipping_country:""},component_form:"",initialize:function(){this.getIdSeparator(),this.initFormFields(),this.autocomplete=new google.maps.places.Autocomplete(document.getElementById("shipping_address_1"),{types:["geocode"]}),google.maps.event.addListener(this.autocomplete,"place_changed",function(e){RpCheckoutAutocomplete_shipping.method.fillInAddress()});var e=document.getElementById("shipping_address_1");null!=e&&e.addEventListener("focus",function(e){RpCheckoutAutocomplete_shipping.method.setAutocompleteCountry()},!0);var t=document.getElementById("shipping_country");null!=t&&t.addEventListener("change",function(e){RpCheckoutAutocomplete_shipping.method.setAutocompleteCountry()},!0)},getIdSeparator:function(){return document.getElementById("shipping_address_1")?(this.IdSeparator=":",":"):(this.IdSeparator="_","_")},initFormFields:function(){for(var e in this.formFields)this.formFields[e]=e;this.component_form={street_number:["shipping_address_1","short_name"],route:["shipping_address_1","long_name"],locality:["shipping_city","long_name"],administrative_area_level_1:["shipping_state","short_name"],country:["shipping_country","long_name"],postal_code:["shipping_postcode","short_name"]}},fillInAddress:function(){this.clearFormValues();var e=this.autocomplete.getPlace();this.resetForm();for(var t in e.address_components)for(var n in e.address_components[t].types)for(var o in this.component_form){if(o==e.address_components[t].types[n]){"street_number"==o?this.streetNumber=e.address_components[t].short_name:"KR"==document.getElementById("shipping_country").value&&(this.streetNumber=e.address_components[0].short_name,this.streetNumber+=","+e.address_components[1].long_name);var i=this.component_form[o][1];e.address_components[t].hasOwnProperty(i)&&(this.formFieldsValue[this.component_form[o][0]]=e.address_components[t][i])}}this.appendStreetNumber(),this.fillForm(),$=jQuery.noConflict(),$("#shipping_state").trigger("change"),"undefined"!=typeof FireCheckout&&checkout.update(checkout.urls.shipping_address)},clearFormValues:function(){for(var e in this.formFieldsValue)this.formFieldsValue[e]=""},appendStreetNumber:function(){""!=this.streetNumber&&(this.formFieldsValue.shipping_address_1=this.streetNumber+" "+this.formFieldsValue.shipping_address_1)},fillForm:function(){for(var e in this.formFieldsValue)if("shipping_country"==e)this.selectRegion(e,this.formFieldsValue[e]);else{if(null===document.getElementById(e))continue;document.getElementById(e).value=this.formFieldsValue[e]}},selectRegion:function(e,t){if(null==document.getElementById(e))return!1;for(var n=document.getElementById(e),o=0;o<n.options.length;o++)if(n.options[o].text==t){n.selectedIndex=o;break}},resetForm:function(){null!==document.getElementById("shipping_address_2")&&(document.getElementById("shipping_address_2").value="")},setAutocompleteCountry:function(){if(null===document.getElementById("shipping_country"))e="FR";else var e=document.getElementById("shipping_country").value;this.autocomplete.setComponentRestrictions({country:e})}},window.addEventListener("load",function(){RpCheckoutAutocomplete.method.initialize(),RpCheckoutAutocomplete_shipping.method.initialize()});
function autocomplet_set_google_autocomplete(){jQuery(input_fields).each(function(){let e=new google.maps.places.Autocomplete(this);e.addListener("place_changed",function(){e.getPlace();jQuery(input_fields).trigger("change")})})}jQuery(window).on("load",function(){autocomplet_set_google_autocomplete()});