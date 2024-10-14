var filkersDesignUidItemView = elementor.modules.controls.BaseMultiple.extend({

    onBaseInputTextChange: function (event) {

        // Interceptamos el cambio de designuid y hacemos una peticion a la API para resolver
        var input = event.currentTarget;
        var inputId = input.getAttribute('data-setting');
        if (inputId === 'designUid') {
            this.onDesignUidChange();
        }

        elementor.modules.controls.BaseMultiple.prototype.onBaseInputTextChange.apply(this, arguments);
    },

    onDesignUidChange: function () {
        var designUidInput = this.$("[data-setting='designUid']")[0];
        var designUid = designUidInput.value;
        var aspectRatioInput = this.$("[data-setting='aspectRatio']")[0];
        var errorMessageHolder = this.$("[data-setting='error']")[0];

        if (designUid === undefined || designUid === null || designUid === '') {
            this.setInputValue(errorMessageHolder, '');
            this.setValue({aspectRatio: 1, valid: 0, error: ''});

        } else {
            fetch(`https://apirest.filkers.com/api/widgets/v1/design/${designUid}`)
                .then(rsp => {
                    if (rsp.ok === true) {
                        rsp.json()
                            .then(data => {
                                var design = data.design;
                                this.setInputValue(errorMessageHolder, '');
                                this.setValue({aspectRatio: design.aspectRatio, valid: 1, error: ''});

                            });
                    } else {
                        rsp.text().then(error => {
                            var errorMessage = error;
                            switch (error) {
                                case "error.design.notFound":
                                    errorMessage = 'Invalid design UID';
                                    break;

                                case "error.design.private":
                                    errorMessage = 'Design access denied';
                                    break;
                            }
                            this.setInputValue(errorMessageHolder, errorMessage);
                            this.setValue({aspectRatio: 0.8, valid: 0, error: errorMessage});
                        })
                    }
                })
                .catch(err => {
                    console.error(`Network error: ${err}`);
                });
        }

    },

    setInputValue: function (input, value) {
        var $input = this.$(input);
        var inputType = $input.attr('type');

        if (inputType !== undefined) {
            elementor.modules.controls.BaseMultiple.prototype.setInputValue.apply(this, arguments);
        } else {
            $input.html(value);
        }
    },

});
elementor.addControlView('filkers-design-uid', filkersDesignUidItemView);