
function saint_axe(type, content)
{
    if ( type == 'JUNOS')
        return saint_axe_junos(content)
    else if ( type == 'SCREENOS')
        return saint_axe_screenos(content)
    else if ( type == 'json')
        return saint_axe_json(content)
    else if ( type == 'patch')
        return saint_axe_patch(content)
    return content;
}

function saint_axe_patch(content)
{
    var StAx_identifier = 'StAx_patch';
    content = content.replace(/^(\+.*)$/gm, '<span class="'+StAx_identifier+'_add">$1</span>')
    content = content.replace(/^(-.*)$/gm, '<span class="'+StAx_identifier+'_delete">$1</span>')
    content = content.replace(/^(@@.*)$/gm, '<span class="'+StAx_identifier+'_comment">$1</span>')
    return content;
}

function saint_axe_screenos(content)
{
    var StAx_identifier = 'StAx_screenos';
    content = content.replace(/(unset|[^n]set|show)/g, '<span class="'+StAx_identifier+'_kw">$1</span>')
    content = content.replace(/(policy|security|polocies|permit|deny)/g, '<span class="'+StAx_identifier+'_group">$1</span>')
    content = content.replace(/(id|protocol|from|to)/g, '<span class="'+StAx_identifier+'_item">$1</span>')
    return content;
}


function saint_axe_junos(content)
{
    var StAx_identifier = 'StAx_junos';
    content = content.replace(/(set|match|delete|then)/g, '<span class="'+StAx_identifier+'_kw">$1</span>')
    content = content.replace(/(applications|security|polocies|permit|deny)/g, '<span class="'+StAx_identifier+'_group">$1</span>')
    content = content.replace(/(application[^s]|protocol|source-port|destination-port|destination-address|source-address|from-zone|to-zone|policy)/g, '<span class="'+StAx_identifier+'_item">$1</span>')
    return content;
}

function saint_axe_json(content)
{
    var StAx_identifier = 'StAx_json';
    /*content = content.replace(/(\"(\w|\d)*\":)/g, '<span class="'+StAx_identifier+'_key">$1</span>')
    content = content.replace(/(\{|\})/g, '<span class="'+StAx_identifier+'_kw">$1</span>')
    content = content.replace(/(application[^s]|protocol|source-port|destination-port|destination-address|source-address|from-zone|to-zone|policy)/g, '<span class="'+StAx_identifier+'_item">$1</span>')*/
    return content;
}