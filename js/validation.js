/**
 * This function returns either the string value of a node if it has one, or an empty string.
 * 
 * @param {Node} param_node The node to extract the value from
 * @returns {undefined}
 */
function _getSafeNodeVal(param_node) {
    return param_node ? param_node.value : "";
}

/**
 * This function displays the next element node from a given one.
 * 
 * @param {*} param_node The desired node, expected to precede some other node
 * @param {Boolean} param_disp Whether to display the next sibling or not
 * @returns {undefined}
 */
function _dispNextElem(param_node, param_disp) {
    const next_elem = param_node.nextElementSibling;
    if (next_elem) {
        next_elem.style = "display: " + (param_disp ? "block" : "none");
    }
}

/**
 * This function validates the input for the PHP checkout page, returning whether the input is acceptable.
 * 
 * @param {Array[String]} in_checkout_ids An array of strings representing the input fields' IDs, all in order
 * @param {Boolean} warning Whether to warn the user through a JS Alert of their offending fields
 * @returns {Boolean} Whether the input is acceptable
 */
function valInputCheckoutWithPHP(in_checkout_ids, warning = false) {

    /*
    Some Regex expressions have been used here:
    - Emails are credited toward Tyler McGinnis: https://ui.dev/validate-email-address-javascript/
    - Cities are credited toward pcalcao: https://stackoverflow.com/questions/11757013/regular-expressions-for-city-name
    */
    const rgx_email = /^\S+@\S+\.\S+$/;
    const rgx_fname = /^[a-zA-Z\'\-]+$/;
    const rgx_lname = /^[a-zA-Z\'\-]+$/;
    const rgx_address1 = /^[a-zA-Z0-9 \#'-/\(\)\.\,]+$/;
    const rgx_address2 = /^[a-zA-Z0-9 \#'-/\(\)\.\,]*$/;
    const rgx_city = /^[a-zA-Z]+(?:[\s-][a-zA-Z]+)*$/;
    const rgx_province = /^[a-zA-Z]+(?:[\s-][a-zA-Z]+)*$/;
    const rgx_postal = /^[a-zA-Z0-9 \-\.\,]+$/;

    // Extract nodes and their values from the given nodes (using the parameter IDs), putting them in `node_props`
    const rgx_tests = [rgx_email, rgx_fname, rgx_lname, rgx_address1, rgx_address2, rgx_city, rgx_province, rgx_postal];
    const node_props = in_checkout_ids.map((nodeid) => {
        const curr_node = document.getElementById(nodeid);
        return { node: curr_node, node_val: _getSafeNodeVal(curr_node) };
    });

    // RegExp test all node values, displaying errors (expected to be the node's next sibling) when unsatisfied
    let rgx_test = true;
    for (let zip_ind = 0; zip_ind < node_props.length; zip_ind++) {
        const curr_node_val = node_props[zip_ind]['node_val'];
        const matches = rgx_tests[zip_ind].test(curr_node_val.trim()) && curr_node_val.length <= 200;
        _dispNextElem(node_props[zip_ind]['node'], !matches);
        rgx_test = rgx_test && matches;
        if (warning && !matches) alert("OFFENDING FIELD: " + in_checkout_ids[zip_ind]);
    }

    // Returns whether all RegExp tests were satisfied
    return rgx_test;
}

/**
 * This function validates the input for the PHP billing page, returning whether the input is acceptable.
 * 
 * @param {Array[String]} in_billing_ids An array of strings representing the input fields' IDs, all in order
 * @returns {Boolean} Whether the input is acceptable
 */
function valInputBillingWithPHP(in_billing_ids) {
    const rgx_billname = /^[a-zA-Z\'\- ]+$/;
    const rgx_cardnum = /^[0-9]+$/;
    const rgx_cardexp = /^(1[0-2]|0[1-9])\/[0-9]{2}$/;
    const rgx_cvv = /^[0-9]{3}$/;

    // Extract nodes and their values from the given nodes (using the parameter IDs), putting them in `node_props`
    const rgx_tests = [rgx_billname, rgx_cardnum, rgx_cardexp, rgx_cvv];
    const node_props = in_billing_ids.map((nodeid) => {
        const curr_node = document.getElementById(nodeid);
        return { node: curr_node, node_val: _getSafeNodeVal(curr_node) };
    });

    // RegExp test all node values, displaying errors (expected to be the node's next sibling) when unsatisfied
    let rgx_test = true;
    for (let zip_ind = 0; zip_ind < node_props.length; zip_ind++) {
        const curr_node_val = node_props[zip_ind]['node_val'];
        const matches = rgx_tests[zip_ind].test(curr_node_val.trim()) && curr_node_val.length <= 200;
        _dispNextElem(node_props[zip_ind]['node'], !matches);
        rgx_test = rgx_test && matches;
    }

    // Returns whether all RegExp tests were satisfied
    return rgx_test;
}