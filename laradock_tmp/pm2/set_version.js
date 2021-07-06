var fs = require('fs');
let version_current = require('/app/version.json').version;

let all_version = version_current.split('.');
all_version[2] = parseInt(all_version[2]) + 1;

all_version = all_version.join('.');

fs.writeFileSync('version.json', '{"version":"'+all_version+'"}');
