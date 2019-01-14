const config = require('../build-config').gulp

require('./tasks/replaceVersion')(config)
require('./tasks/revAssets')(config)
require('./tasks/revRevvedFiles')(config)
require('./tasks/revStaticFiles')(config)
require('./tasks/revUpdateReferences')(config)
require('./tasks/rev')(config)
