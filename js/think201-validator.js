(function($) {
    "use strict";

    var namespace = '.validator';

    var defaults = {
        events: null,
        selector: null,
        validationAttribute: 'validations',
        preventDefault: false,
        preventDefaultIfInvalid: false,
        callback: function(elem, valid) {},
        done: function(valid) {}
    };

    var validations = {

        parseRules: function(rules) {

            var validations = [],
                rule;

            $.each(rules.split("|"), function(idx, value) {

                rule = value.split(":");
                validations.push({
                    method: "validate_" + rule[0],
                    params: rule[1] ? rule[1].split(",") : [],
                    original: value
                });

            });

            return validations;

        },

        validate: function(options) {

            var selector = options.selector,
                attribute = options.validationAttribute,
                callback = options.callback,
                allValid = true;

            $(selector).each(function() {

                var validation_rules = $(this).data(attribute),
                    name = $(this).attr("name"),
                    value = $(this).val(),
                    rules = [],
                    brokenRules = [],
                    method = null,
                    valid = true;

                if (!validation_rules || !name) {
                    return true;
                }

                rules = validations.parseRules(validation_rules);

                var brokenRuleParam = null;

                $.each(rules, function(idx, rule) {

                    var thisValid;

                    if (!validations.validatable(rule, name, value)) {
                        return true;
                    }

                    method = validations[rule.method] || options[rule.method];

                    thisValid = method ?
                        method.apply(validations, [name, value, rule.params]) :
                        false;

                    valid = valid && thisValid;

                    if (!thisValid) {
                        brokenRules.push(rule.original.split(":")[0]);
                        brokenRuleParam = rule.params;

                        return false;
                    }

                });

                validations.showValidStatus(this, valid, brokenRules, brokenRuleParam);

                callback(this, valid, brokenRules.join('|'));

                allValid = allValid && valid;

            });

            return allValid;

        },

        getAllFormElems: function(formObj)
        {
            var FormElements = new Array();

            formObj.find("input").each(function()
            {
                FormElements.push($(this));
            });

            formObj.find("select").each(function()
            {
                FormElements.push($(this));
            });

            formObj.find("textarea").each(function()
            {
                FormElements.push($(this));
            });

            return FormElements;        
        },        

        checkform: function(formObj)
        {
            var allValid = true;

            var FormElems = this.getAllFormElems(formObj);

            $(FormElems).each(function() 
            {
                var validation_rules = $(this).data(attribute),
                    name = $(this).attr("name"),
                    value = $(this).val(),
                    rules = [],
                    brokenRules = [],
                    method = null,
                    valid = true;

                if (!validation_rules || !name) {
                    return true;
                }

                rules = validations.parseRules(validation_rules);

                var brokenRuleParam = null;

                $.each(rules, function(idx, rule) {

                    var thisValid;

                    if (!validations.validatable(rule, name, value)) {
                        return true;
                    }

                    method = validations[rule.method] || options[rule.method];

                    thisValid = method ?
                        method.apply(validations, [name, value, rule.params]) :
                        false;

                    valid = valid && thisValid;

                    if (!thisValid) {
                        brokenRules.push(rule.original.split(":")[0]);
                        brokenRuleParam = rule.params;

                        return false;
                    }

                });

                validations.showValidStatus(this, valid, brokenRules, brokenRuleParam);

                callback(this, valid, brokenRules.join('|'));

                allValid = allValid && valid;

            });

            return allValid;
        },

        showValidStatus: function(elem, valid, brokenRules, params) {
            if (valid) {
                $(elem).addClass('success').removeClass('error');
                $(elem).siblings('.valid').remove();
                $(elem).siblings('.notvalid').remove();
                $(elem).siblings('.error-msg').remove();
                $(elem).removeClass("error");
                $(elem).parent().append($('<i class="valid fa fa-check-circle"></i>').fadeIn(200));
            } else {
                var Msg = validations.statusMessage(brokenRules[0], params);

                $(elem).addClass('error').removeClass('success');
                $(elem).siblings('.valid').remove();
                $(elem).siblings('.notvalid').remove();
                $(elem).parent().find('.error-msg').remove();
                $(elem).addClass("error");
                $(elem).parent().append($('<i class="notvalid fa fa-times-circle"></i>').fadeIn(200));
                $(elem).parent().append($('<span class="error-msg">' + Msg + '</span>').fadeIn(200));
            }
        },

        validatable: function(rule, attribute, value) {

            return this.validate_required(attribute, value) ||
                this.implicit(rule);
        },

        implicit: function(rule) {

            return rule.method === "validate_required" ||
                rule.method === "validate_required_with" ||
                rule.method === "validate_accepted";
        },

        size: function(attribute, value) {

            if (this.validate_numeric(attribute, value)) {
                return parseFloat(value);
            }

            return value.replace(/\r?\n/g, '\r\n').length;
        },

        validate_match: function(attribute, value, parameters) {

            if (!(parameters instanceof Array)) {
                parameters = [parameters];
            }

            if (!(value instanceof Array)) {
                value = [value];
            }

            var i = 0,
                re = parameters[0];

            if (!(re instanceof RegExp)) {
                re = re.replace(/\/?([^\/]*)\/?/, "$1");
                re = new RegExp(re);
            }

            for (i = 0; i < value.length; i++) {
                if (value[i] !== null && value[i].match(re) !== null) {
                    return true;
                }
            }

            return false;
        },

        validate_regex: function(attribute, value, parameters) {
            return this.validate_match(attribute, value, parameters);
        },

        validate_required: function(attribute, value) {

            if ($("[name=\"" + attribute + "\"]").first().is(':radio')) {
                return $("[name=\"" + attribute + "\"]:checked").val() !== undefined;
            }

            return this.validate_match(attribute, value, /[^\s]+/);
        },

        validate_required_with: function(attribute, value, parameters) {

            if (this.validate_required(parameters[0], $("[name=\"" + parameters[0] + "\"]").val())) {
                return this.validate_required(attribute, value);
            }

            return true;
        },

        validate_confirmed: function(attribute, value) {

            return this.validate_same(attribute, value, [attribute + "_confirmation"]);
        },

        validate_accepted: function(attribute, value) {

            var input = $("[name=\"" + attribute + "\"]");

            return input.is(":checkbox") ?
                input.is(":checked") :
                this.validate_match(attribute, value, /^(yes|1)$/);
        },

        validate_same: function(attribute, value, parameters) {

            return value === $("[name=\"" + parameters[0] + "\"]").val();
        },

        validate_different: function(attribute, value, parameters) {

            return value !== $("[name=\"" + parameters[0] + "\"]").val();
        },

        validate_numeric: function(attribute, value) {

            return this.validate_match(attribute, value, /^-?\d+(\.\d*)?$/);

        },

        validate_integer: function(attribute, value) {

            return this.validate_match(attribute, value, /^-?\d+$/);

        },

        validate_size: function(attribute, value, parameters) {

            return this.size(attribute, value) === parseFloat(parameters[0]);

        },

        validate_between: function(attribute, value, parameters) {

            var size = this.size(attribute, value);

            return size >= parseFloat(parameters[0]) && size <= parseFloat(parameters[1]);

        },

        validate_digits: function(attribute, value, parameters) {

            if (this.validate_match(attribute, value, /^-?\d+$/)) {
                return value.length == parameters[0] ? true : false;
            }

            return false;
        },

        validate_digits_between: function(attribute, value, parameters) {

            if (this.validate_match(attribute, value, /^-?\d+$/)) {
                return value.length >= parameters[0] && value.length <= parameters[1] ? true : false;;
            }

            return false;
        },

        validate_min: function(attribute, value, parameters) {

            return this.size(attribute, value) >= parseFloat(parameters[0]);

        },

        validate_max: function(attribute, value, parameters) {

            return this.size(attribute, value) <= parseFloat(parameters[0]);

        },

        validate_in: function(attribute, value, parameters) {

            return $.inArray(value, parameters) >= 0;

        },

        validate_not_in: function(attribute, value, parameters) {

            return $.inArray(value, parameters) < 0;

        },

        validate_unique: function(attribute, value, parameters) {

            return true;

        },

        validate_exists: function(attribute, value, parameters) {

            return true;

        },

        validate_ip: function(attribute, value) {

            var segments = value.split(".");

            if (segments.length === 4 &&
                this.validate_between(attribute, segments[0], [1, 255]) &&
                this.validate_between(attribute, segments[1], [0, 255]) &&
                this.validate_between(attribute, segments[2], [0, 255]) &&
                this.validate_between(attribute, segments[3], [1, 255])) {
                return true;
            }

            return false;

        },

        validate_email: function(attribute, value) {

            return this.validate_match(attribute, value, /^[A-Z0-9._%+\-]+@[A-Z0-9.\-]+\.[A-Z]{2,4}$/i);

        },

        validate_url: function(attribute, value) {

            return this.validate_match(attribute, value, /^(https?|ftp):\/\/[^\s\/$.?#].[^\s]*$/i);

        },

        validate_active_url: function(attribute, value) {

            return this.validate_url(attribute, value);

        },

        validate_image: function(attribute, value, parameters) {

            return this.validate_mimes(attribute, value, ['jpg', 'png', 'gif', 'bmp']);

        },

        validate_alpha: function(attribute, value, parameters) {

            return this.validate_match(attribute, value, /^([a-z])+$/i);

        },

        validate_alpha_num: function(attribute, value, parameters) {

            return this.validate_match(attribute, value, /^([a-z0-9])+$/i);

        },

        validate_alpha_dash: function(attribute, value, parameters) {

            return this.validate_match(attribute, value, /^([a-z0-9_\-])+$/i);

        },

        validate_mimes: function(attribute, value, parameters) {

            var i, re;
            for (i = 0; i < parameters.length; i++) {
                re = new RegExp('\\.' + parameters[i] + '$');

                if (this.validate_match(attribute, value, re)) {
                    return true;
                }
            }

            return false;

        },

        validate_before: function(attribute, value, parameters) {

            return (Date.parse(value) < Date.parse(parameters[0]));

        },

        validate_after: function(attribute, value, parameters) {

            return (Date.parse(value) > Date.parse(parameters[0]));

        },

        statusMessage: function(Type, Params) {
            var Msg = Array();

            Msg['required'] = "You can't leave this empty!";
            Msg['confirmed'] = "Both the values didn't match.";
            Msg['accepted'] = "You need to accept this in order to continue!";
            Msg['numeric'] = "Only numbers are allowed for this field";
            Msg['integer'] = "Only integer values are allowed here";
            Msg['email'] = "Looks like this is not a valid email id.";
            Msg['url'] = "This doesn't seem to be a valid url";
            Msg['image'] = "This is not a valid image";
            Msg['alpha_dash'] = "This field accepts only alphanumeric, dash (-) & underscore (_)";
            Msg['between'] = "This field should be between " + Params[0] + " to " + Params[1] + " chars long";
            Msg['max'] = "The value you have entered should have max limit of " + Params[0] + " digits";
            Msg['min'] = "The value you have entered should have min limit of " + Params[0] + " digits";
            Msg['digits'] = "This field should have value of " + Params[0] + " digits length";
            Msg['digits_between'] = "Accepts digits only of length " + Params[0] + " to " + Params[1] + " digits long";

            if (Type in Msg) {
                return Msg[Type];
            } else {
                return 'This is invalid entry!'
            }
        }
    };

    var methods = {
        make: function(options) {

            var selector;

            if (options.events == 'submit') {
                selector = options.formId + ' ' + options.selector;
            } else {
                selector = options.selector;
            }

            if (options === 'undefined') {
                $.error('jQuery' + namespace + ' may not be intialized without options.');
            }

            options = $.extend({}, defaults, options);
            options.events = options.events.replace(/(\w+)/g, "$1" + namespace + " ");

            this.each(function() {

                $(this).on(options.events, function(evt) {

                    var valid;

                    options.selector = selector || this;

                    valid = validations.validate(options);

                    if ((!valid && options.preventDefaultIfInvalid) || options.preventDefault) {
                        evt.preventDefault();
                    }

                    if (options.done) {
                        options.done(valid);
                    }

                });

            });

            return this;
        },

        destroy: function() {

            this.each(function() {

                $(this).off(namespace);

            });

            return this;
        },

        checkform: function(formObj)
        {
            var allValid = true;

            var FormElems = validations.getAllFormElems(formObj);

            $.each(FormElems, function(index, value) 
            {
                var validation_rules = value.data('validations'),
                    name = value.attr("name"),
                    value = value.val(),
                    rules = [],
                    brokenRules = [],
                    method = null,
                    valid = true;

                if (!validation_rules || !name) {
                    return true;
        }

                rules = validations.parseRules(validation_rules);

                var brokenRuleParam = null;

                $.each(rules, function(idx, rule) {

                    var thisValid;

                    if (!validations.validatable(rule, name, value)) {
                        return true;
                    }

                    method = validations[rule.method] || options[rule.method];

                    thisValid = method ?
                        method.apply(validations, [name, value, rule.params]) :
                        false;

                    valid = valid && thisValid;

                    if (!thisValid) {
                        brokenRules.push(rule.original.split(":")[0]);
                        brokenRuleParam = rule.params;

                        return false;
                    }

                });

                validations.showValidStatus(this, valid, brokenRules, brokenRuleParam);

                //callback(this, valid, brokenRules.join('|'));

                allValid = allValid && valid;

            });

            return allValid;
        },
    };

    $.fn.validator = function(method) {

        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.make.apply(this, arguments);
        } else {
            $.error('Method ' + method + ' does not exist on jQuery' + namespace);
        }

        return this;
    };

}(jQuery));
