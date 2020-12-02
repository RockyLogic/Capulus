function _getSafeNodeVal(param_str) {
    return param_str ? param_str.value : "";
}

function _dispNextElem(param_node, param_disp) {
    const next_elem = param_node.nextElementSibling;
    if (next_elem) {
        next_elem.style = "display: " + (param_disp ? "block" : "none");
    }
}

function valInputCheckout(in_checkout_ids) {
    /*
    Some Regex expressions have been used here:
    - Emails are credited toward Tyler McGinnis: https://ui.dev/validate-email-address-javascript/
    - Cities are credited toward pcalcao: https://stackoverflow.com/questions/11757013/regular-expressions-for-city-name
    */
    const storage_names = ["caps-in-email", "caps-in-fname", "caps-in-lname", "caps-in-address1", "caps-in-address2", "caps-in-city", "caps-in-province", "caps-in-postal"];
    const rgx_email = /^\S+@\S+\.\S+$/;
    const rgx_fname = /^[a-zA-Z\'\-]+$/;
    const rgx_lname = /^[a-zA-Z\'\-]+$/;
    const rgx_address1 = /^[a-zA-Z0-9 \#'-/\(\)\.\,]+$/;
    const rgx_address2 = /^[a-zA-Z0-9 \#'-/\(\)\.\,]*$/;
    const rgx_city = /^[a-zA-Z]+(?:[\s-][a-zA-Z]+)*$/;
    const rgx_province = /^[a-zA-Z]+(?:[\s-][a-zA-Z]+)*$/;
    const rgx_postal = /^[a-zA-Z0-9 \-\.\,]+$/;

    const rgx_tests = [rgx_email, rgx_fname, rgx_lname, rgx_address1, rgx_address2, rgx_city, rgx_province, rgx_postal];
    const node_props = in_checkout_ids.map((nodeid) => {
        const curr_node = document.getElementById(nodeid);
        return { node: curr_node, node_val: _getSafeNodeVal(curr_node) };
    });
    let rgx_test = true;
    for (let zip_ind = 0; zip_ind < node_props.length; zip_ind++) {
        const curr_node_val = node_props[zip_ind]['node_val'];
        const matches = rgx_tests[zip_ind].test(curr_node_val.trim()) && curr_node_val.length <= 200;
        _dispNextElem(node_props[zip_ind]['node'], !matches);
        rgx_test = rgx_test && matches;
    }
    if (rgx_test) {
        for (let zip_ind = 0; zip_ind < node_props.length; zip_ind++) {
            window.sessionStorage.setItem(storage_names[zip_ind], node_props[zip_ind]['node_val'].trim());
        }
    }
    return rgx_test;
}

function valInputBilling(in_checkout_ids) {
    const storage_names = ["caps-in-billname", "caps-in-cardnum", "caps-in-expiry", "caps-in-cvv"];
    const rgx_billname = /^[a-zA-Z\'\- ]+$/;
    const rgx_cardnum = /^[0-9]+$/;
    const rgx_cardexp = /^[0-9]{2}\/[0-9]{2}$/;
    const rgx_cvv = /^[0-9]{3}$/;

    const rgx_tests = [rgx_billname, rgx_cardnum, rgx_cardexp, rgx_cvv];
    const node_props = in_checkout_ids.map((nodeid) => {
        const curr_node = document.getElementById(nodeid);
        return { node: curr_node, node_val: _getSafeNodeVal(curr_node) };
    });
    let rgx_test = true;
    for (let zip_ind = 0; zip_ind < node_props.length; zip_ind++) {
        const curr_node_val = node_props[zip_ind]['node_val'];
        const matches = rgx_tests[zip_ind].test(curr_node_val.trim()) && curr_node_val.length <= 200;
        _dispNextElem(node_props[zip_ind]['node'], !matches);
        rgx_test = rgx_test && matches;
    }
    if (rgx_test) {
        for (let zip_ind = 0; zip_ind < node_props.length; zip_ind++) {
            window.sessionStorage.setItem(storage_names[zip_ind], node_props[zip_ind]['node_val'].trim());
        }
    }
    return rgx_test;
}

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

    const rgx_tests = [rgx_email, rgx_fname, rgx_lname, rgx_address1, rgx_address2, rgx_city, rgx_province, rgx_postal];
    const node_props = in_checkout_ids.map((nodeid) => {
        const curr_node = document.getElementById(nodeid);
        return { node: curr_node, node_val: _getSafeNodeVal(curr_node) };
    });
    let rgx_test = true;
    for (let zip_ind = 0; zip_ind < node_props.length; zip_ind++) {
        const curr_node_val = node_props[zip_ind]['node_val'];
        const matches = rgx_tests[zip_ind].test(curr_node_val.trim()) && curr_node_val.length <= 200;
        _dispNextElem(node_props[zip_ind]['node'], !matches);
        rgx_test = rgx_test && matches;
        if (warning && !matches) alert("OFFENDING FIELD: " + in_checkout_ids[zip_ind]);
    }
    return rgx_test;
}

function valInputBillingWithPHP(in_checkout_ids) {
    const rgx_billname = /^[a-zA-Z\'\- ]+$/;
    const rgx_cardnum = /^[0-9]+$/;
    const rgx_cardexp = /^[0-9]{2}\/[0-9]{2}$/;
    const rgx_cvv = /^[0-9]{3}$/;

    const rgx_tests = [rgx_billname, rgx_cardnum, rgx_cardexp, rgx_cvv];
    const node_props = in_checkout_ids.map((nodeid) => {
        const curr_node = document.getElementById(nodeid);
        return { node: curr_node, node_val: _getSafeNodeVal(curr_node) };
    });
    let rgx_test = true;
    for (let zip_ind = 0; zip_ind < node_props.length; zip_ind++) {
        const curr_node_val = node_props[zip_ind]['node_val'];
        const matches = rgx_tests[zip_ind].test(curr_node_val.trim()) && curr_node_val.length <= 200;
        _dispNextElem(node_props[zip_ind]['node'], !matches);
        rgx_test = rgx_test && matches;
    }
    return rgx_test;
}