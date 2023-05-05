/*
Language: MKB
Description: BASIC Scripting language interpretted by the minecraft macro/keybind mod.
Author: Mumfrey
Website: https://beta.mkb.gorlem.ml/docs/actions/
Category: scripting
*/
// node tools/build.js -n mkb

export default function(hljs) {

    const MKB_ACTIONS = [
        'ACHIEVEMENTGET|10','ARRAYSIZE','ASSIGN','BIND','BINDGUI','BREAK','CALCYAWTO','CAMERA','CHATFILTER',
        'CHATHEIGHT|10','CHATHEIGHTFOCUSED|10','CHATOPACITY','CHATSCALE','CHATVISIBLE','CHATWIDTH',
        'CLEARCHAT|10','CLEARCRAFTING|10','CONFIG','CRAFT','CRAFTANDWAIT|10','DEC','DECODE','DISCONNECT',
        'DO','ECHO','ELSE','ELSEIF','ENCODE','ENDIF','ENDUNSAFE','EXEC','FILTER','FOG','FOR','FOREACH','FOV',
        'GAMMA|10','GETID|10','GETIDREL|10','GETITEMINFO|10','GETPROPERTY','GETSLOT','GETSLOTITEM|10','GUI','IF','IFBEGINSWITH',
        'IFCONTAINS','IFENDSWITH','IFMATCHES','IIF','IMPORT','INC','INDEXOF','INVENTORYDOWN|10','INVENTORYUP|10',
        'ISRUNNING','ITEMID','ITEMNAME','JOIN','KEY','KEYDOWN','KEYUP','LCASE','LOG','LOGRAW','LOGTO','LOOK','LOOKS',
        'LOOP','MATCH','MODIFY','MUSIC','NEXT','PASS','PICK','PLACESIGN','PLAYSOUND','POP','POPUPMESSAGE','PRESS','PROMPT',
        'PUSH','PUT','RANDOM','REGEXREPLACE','RELOADRESOURCES|10','REPL','REPLACE','RESOURCEPACK|10','RESOURCEPACKS|10',
        'RESPAWN|10','SELECTCHANNEL','SENDMESSAGE','SENSITIVITY','SET','SETLABEL','SETPROPERTY','SETRES','SETSLOTITEM|10',
        'SHADERGROUP|10','SHOWGUI','SLOT','SLOTCLICK','SPLIT','SPRINT','SQRT','STOP','STORE','STOREOVER','STRIP','TEXTUREPACK|10',
        'TILEID','TILENAME','TIME','TITLE','TOAST','TOGGLE','TOGGLEKEY','TRACE','TYPE','UCASE','UNIMPORT','UNSAFE','UNSET',
        'UNSPRINT','UNTIL','VOLUME','WAIT','WALKTO','WHILE'
    ];
    const MKB_EVENTS = [
        'onArmourChange','onArmourDurabilityChange','onAutoCraftingComplete','onChat','onConfigChange',
        'onFilterableChat','onFoodChange','onHealthChange','onInventorySlotChange','onItemDurabilityChange',
        'onJoinGame','onLevelChange','onModeChange','onOxygenChange','onPickupItem','onPlayerJoined',
        'onSendChatMessage','onShowGui','onWeatherChange','onWorldChange','onXPChange'
    ];
    const MKB_ITERATORS = [
        'controls','effects','enchantments','env','players','properties','running'
    ];
    // \$\$(?:\!|\?|\d|\w*(?::\d*)?)|(?:\[\[(?:\w|\d|\s)*\]\])|(?:\[\w*|\d*\])|(?:\<\w*\.txt\>)
    const MKB_PARAMETERS = [
        '$$!','$$?','$$[[arrayofthings]]','$$[name]','$$<file.txt>','$$0-9','$$d','$$f','$$h','$$i','$$i:d','$$k','$$m','$$p','$$pn','$$px','$$py','$$pz','$$s','$$t','$$u','$$w'
    ];
    /* REPL Reserved.
    const MKB_REPL = [
       'BEGIN','CAT','CLS','EDIT','END','EXIT','EXPAND','HELP','KILL','LIST','LIVE','RM','RUN','SAY','SHUTDOWN','TASKS','VERSION','WHOAMI'
    ]
    */
    const MKB_VARIABLES = [
        '~ALT','~CTRL','~KEY_<name>','~KEY_0','~KEY_1','~KEY_2','~KEY_3','~KEY_4','~KEY_5','~KEY_6','~KEY_7',
        '~KEY_8','~KEY_9','~KEY_A','~KEY_ADD','~KEY_APOSTROPHE','~KEY_APPS','~KEY_AT','~KEY_AX','~KEY_B','~KEY_BACK',
        '~KEY_BACKSLASH','~KEY_C','~KEY_CAPITAL','~KEY_CIRCUMFLEX','~KEY_CLEAR','~KEY_COLON','~KEY_COMMA',
        '~KEY_CONVERT','~KEY_D','~KEY_DECIMAL','~KEY_DELETE','~KEY_DIVIDE','~KEY_DOWN','~KEY_E','~KEY_END',
        '~KEY_EQUALS','~KEY_ESCAPE','~KEY_F','~KEY_F1','~KEY_F10','~KEY_F11','~KEY_F12','~KEY_F13','~KEY_F14',
        '~KEY_F15','~KEY_F16','~KEY_F17','~KEY_F18','~KEY_F19','~KEY_F2','~KEY_F3','~KEY_F4','~KEY_F5','~KEY_F6',
        '~KEY_F7','~KEY_F8','~KEY_F9','~KEY_FUNCTION','~KEY_G','~KEY_GRAVE','~KEY_H','~KEY_HOME','~KEY_I',
        '~KEY_INSERT','~KEY_J','~KEY_K','~KEY_KANA','~KEY_KANJI','~KEY_L','~KEY_LBRACKET','~KEY_LCONTROL',
        '~KEY_LEFT','~KEY_LMENU','~KEY_LMETA','~KEY_LSHIFT','~KEY_M','~KEY_MINUS','~KEY_MOUSE3','~KEY_MOUSE4',
        '~KEY_MULTIPLY','~KEY_N','~KEY_NEXT','~KEY_NOCONVERT','~KEY_NONE','~KEY_NUMLOCK','~KEY_NUMPAD0',
        '~KEY_NUMPAD1','~KEY_NUMPAD2','~KEY_NUMPAD3','~KEY_NUMPAD4','~KEY_NUMPAD5','~KEY_NUMPAD6','~KEY_NUMPAD7',
        '~KEY_NUMPAD8','~KEY_NUMPAD9','~KEY_NUMPADCOMMA','~KEY_NUMPADENTER','~KEY_NUMPADEQUALS','~KEY_O','~KEY_P',
        '~KEY_PAUSE','~KEY_PERIOD','~KEY_POWER','~KEY_PRIOR','~KEY_Q','~KEY_R','~KEY_RBRACKET','~KEY_RCONTROL',
        '~KEY_RETURN','~KEY_RIGHT','~KEY_RMENU','~KEY_RMETA','~KEY_RSHIFT','~KEY_S','~KEY_SCROLL','~KEY_SECTION',
        '~KEY_SEMICOLON','~KEY_SLASH','~KEY_SLEEP','~KEY_SPACE','~KEY_STOP','~KEY_SUBTRACT','~KEY_SYSRQ','~KEY_T',
        '~KEY_TAB','~KEY_U','~KEY_UNDERLINE','~KEY_UNLABELED','~KEY_UP','~KEY_V','~KEY_W','~KEY_X','~KEY_Y','~KEY_YEN',
        '~KEY_Z','~LMOUSE','~MIDDLEMOUSE','~RMOUSE','~SHIFT','ALT','AMBIENTVOLUME','ARMOUR','ATTACKPOWER','ATTACKSPEED',
        'BIOME','BLOCKVOLUME','BOOTSDAMAGE','BOOTSDURABILITY','BOOTSID','BOOTSNAME','BOWCHARGE','CAMERA','CANFLY',
        'CARDINALYAW','CHAT','CHATCLEAN','CHATMESSAGE','CHATPLAYER','CHESTPLATEDAMAGE','CHESTPLATEDURABILITY',
        'CHESTPLATEID','CHESTPLATENAME','CHUNKUPDATES','CONFIG','CONTAINERSLOTS','CONTROLID','CONTROLNAME',
        'CONTROLTYPE','COOLDOWN','CTRL','DATE','DATETIME','DAY','DAYTICKS','DAYTIME','DIFFICULTY','DIMENSION','DIRECTION',
        'DISPLAYHEIGHT','DISPLAYNAME','DISPLAYWIDTH','DURABILITY','EFFECT','EFFECTID','EFFECTNAME','EFFECTPOWER',
        'EFFECTTIME','ENCHANTMENT','ENCHANTMENTNAME','ENCHANTMENTPOWER','FLYING','FOV','FPS','GAMEMODE','GAMMA','GUI',
        'HEALTH','HELMDAMAGE','HELMDURABILITY','HELMID','HELMNAME','HIT','HIT_<name>','HIT_AGE','HIT_ATTACHED',
        'HIT_AXIS','HIT_BITES','HIT_CHECK_DECAY','HIT_COLOR','HIT_CONDITIONAL','HIT_CONTENTS','HIT_DAMAGE',
        'HIT_DECAYABLE','HIT_DELAY','HIT_DISARMED','HIT_DOWN','HIT_EAST','HIT_ENABLED','HIT_EXPLODE','HIT_EXTENDED',
        'HIT_EYE','HIT_FACING','HIT_HALF','HIT_HAS_BOTTLE_0','HIT_HAS_BOTTLE_1','HIT_HAS_BOTTLE_2','HIT_HAS_RECORD',
        'HIT_HINGE','HIT_IN_WALL','HIT_LAYERS','HIT_LEGACY_DATA','HIT_LEVEL','HIT_LOCKED','HIT_MODE','HIT_MOISTURE',
        'HIT_NODROP','HIT_NORTH','HIT_OCCUPIED','HIT_OPEN','HIT_PART','HIT_POWER','HIT_POWERED','HIT_ROTATION',
        'HIT_SEAMLESS','HIT_SHAPE','HIT_SHORT','HIT_SNOWY','HIT_SOUTH','HIT_STAGE','HIT_TRIGGERED','HIT_TYPE','HIT_UP',
        'HIT_VARIANT','HIT_WEST','HIT_WET','HITDATA','HITID','HITNAME','HITPROGRESS','HITSIDE','HITUUID','HITX','HITY','HITZ',
        'HOSTILEVOLUME','HUNGER','INVSLOT','ITEM','ITEMCODE','ITEMDAMAGE','ITEMIDDMG','ITEMNAME','ITEMUSEPCT','ITEMUSETICKS',
        'JOINEDPLAYER','KEY_<name>','KEY_0','KEY_1','KEY_2','KEY_3','KEY_4','KEY_5','KEY_6','KEY_7','KEY_8','KEY_9','KEY_A',
        'KEY_ADD','KEY_APOSTROPHE','KEY_APPS','KEY_AT','KEY_AX','KEY_B','KEY_BACK','KEY_BACKSLASH','KEY_C','KEY_CAPITAL',
        'KEY_CIRCUMFLEX','KEY_CLEAR','KEY_COLON','KEY_COMMA','KEY_CONVERT','KEY_D','KEY_DECIMAL','KEY_DELETE','KEY_DIVIDE',
        'KEY_DOWN','KEY_E','KEY_END','KEY_EQUALS','KEY_ESCAPE','KEY_F','KEY_F1','KEY_F10','KEY_F11','KEY_F12','KEY_F13',
        'KEY_F14','KEY_F15','KEY_F16','KEY_F17','KEY_F18','KEY_F19','KEY_F2','KEY_F3','KEY_F4','KEY_F5','KEY_F6','KEY_F7','KEY_F8',
        'KEY_F9','KEY_FUNCTION','KEY_G','KEY_GRAVE','KEY_H','KEY_HOME','KEY_I','KEY_INSERT','KEY_J','KEY_K','KEY_KANA','KEY_KANJI',
        'KEY_L','KEY_LBRACKET','KEY_LCONTROL','KEY_LEFT','KEY_LMENU','KEY_LMETA','KEY_LSHIFT','KEY_M','KEY_MINUS','KEY_MOUSE3',
        'KEY_MOUSE4','KEY_MULTIPLY','KEY_N','KEY_NEXT','KEY_NOCONVERT','KEY_NONE','KEY_NUMLOCK','KEY_NUMPAD0','KEY_NUMPAD1',
        'KEY_NUMPAD2','KEY_NUMPAD3','KEY_NUMPAD4','KEY_NUMPAD5','KEY_NUMPAD6','KEY_NUMPAD7','KEY_NUMPAD8','KEY_NUMPAD9',
        'KEY_NUMPADCOMMA','KEY_NUMPADENTER','KEY_NUMPADEQUALS','KEY_O','KEY_P','KEY_PAUSE','KEY_PERIOD','KEY_POWER',
        'KEY_PRIOR','KEY_Q','KEY_R','KEY_RBRACKET','KEY_RCONTROL','KEY_RETURN','KEY_RIGHT','KEY_RMENU','KEY_RMETA',
        'KEY_RSHIFT','KEY_S','KEY_SCROLL','KEY_SECTION','KEY_SEMICOLON','KEY_SLASH','KEY_SLEEP','KEY_SPACE','KEY_STOP',
        'KEY_SUBTRACT','KEY_SYSRQ','KEY_T','KEY_TAB','KEY_U','KEY_UNDERLINE','KEY_UNLABELED','KEY_UP','KEY_V','KEY_W','KEY_X',
        'KEY_Y','KEY_YEN','KEY_Z','KEYID','KEYNAME','LEGGINGSDAMAGE','LEGGINGSDURABILITY','LEGGINGSID','LEGGINGSNAME',
        'LEVEL','LIGHT','LMOUSE','LOCALDIFFICULTY','MACROID','MACRONAME','MACROTIME','MAINHANDCOOLDOWN',
        'MAINHANDDURABILITY','MAINHANDITEM','MAINHANDITEMCODE','MAINHANDITEMDAMAGE','MAINHANDITEMIDDMG',
        'MAINHANDITEMNAME','MAINHANDSTACKSIZE','MAXPLAYERS','MIDDLEMOUSE','MODE','MUSIC','NEUTRALVOLUME',
        'OFFHANDCOOLDOWN','OFFHANDDURABILITY','OFFHANDITEM','OFFHANDITEMCODE','OFFHANDITEMDAMAGE','OFFHANDITEMIDDMG',
        'OFFHANDITEMNAME','OFFHANDSTACKSIZE','OLDINVSLOT','ONLINEPLAYERS','OXYGEN','PICKUPAMOUNT','PICKUPDATA',
        'PICKUPID','PICKUPITEM','PITCH','PLAYER','PLAYERNAME','PLAYERVOLUME','PROPNAME','PROPVALUE','RAIN','REASON',
        'RECORDVOLUME','RESOURCEPACKS[]','RMOUSE','SATURATION','SCREEN','SCREENNAME','SEED','SENSITIVITY','SERVER',
        'SERVERMOTD','SERVERNAME','SHADERGROUP','SHADERGROUPS[]','SHIFT','SIGNTEXT[]','SOUND','STACKSIZE','TEXTUREPACK',
        'TICKS','TIME','TIMESTAMP','TOTALTICKS','TOTALXP','TRACE_<name>','TRACE_AGE','TRACE_ATTACHED','TRACE_AXIS',
        'TRACE_BITES','TRACE_CHECK_DECAY','TRACE_COLOR','TRACE_CONDITIONAL','TRACE_CONTENTS','TRACE_DAMAGE',
        'TRACE_DECAYABLE','TRACE_DELAY','TRACE_DISARMED','TRACE_DOWN','TRACE_EAST','TRACE_ENABLED','TRACE_EXPLODE',
        'TRACE_EXTENDED','TRACE_EYE','TRACE_FACING','TRACE_HALF','TRACE_HAS_BOTTLE_0','TRACE_HAS_BOTTLE_1',
        'TRACE_HAS_BOTTLE_2','TRACE_HAS_RECORD','TRACE_HINGE','TRACE_IN_WALL','TRACE_LAYERS','TRACE_LEGACY_DATA',
        'TRACE_LEVEL','TRACE_LOCKED','TRACE_MODE','TRACE_MOISTURE','TRACE_NODROP','TRACE_NORTH','TRACE_OCCUPIED',
        'TRACE_OPEN','TRACE_PART','TRACE_POWER','TRACE_POWERED','TRACE_ROTATION','TRACE_SEAMLESS','TRACE_SHAPE',
        'TRACE_SHORT','TRACE_SNOWY','TRACE_SOUTH','TRACE_STAGE','TRACE_TRIGGERED','TRACE_TYPE','TRACE_UP',
        'TRACE_VARIANT','TRACE_WEST','TRACE_WET','TRACEDATA','TRACEID','TRACENAME','TRACESIDE','TRACETYPE','TRACEUUID',
        'TRACEX','TRACEY','TRACEZ','UNIQUEID','UUID','VARNAME','VEHICLE','VEHICLEHEALTH','WEATHERVOLUME','XP','XPOS','XPOSF',
        'YAW','YPOS','YPOSF','ZPOS','ZPOSF'
    ]
    // If needed.
    const CONSTANT_STRING = '%?'+MKB_VARIABLES.join(' ')
        .trim()
        .split(' ')
        .map(function(val) { return val.trim().split('|')[0]; })
        .join('|')+'%?';
    const ACTIONS_STRING =MKB_ACTIONS.join(' ')
        .trim()
        .split(' ')
        .map(function(val) { return val.trim().split('|')[0]; })
        .join(' ');
    const PARAMS_RE =MKB_PARAMETERS.join('--')
        .trim()
        .split('--')
        .map(function(val) {
            let word ="";
            val=val.trim().split('|')[0];
            val.split('').forEach((letter)=>{
                if(isNaN(letter)){
                    letter="\\"+letter;
                }
                word += letter;
            });
            return word })
        .join('|')+'|Mumfrey|Dereavy|Lezappen';
    const SUBST = {
        scope:'subst',
        className:'subst',
        begin:PARAMS_RE,
        keywords: MKB_PARAMETERS
    }
    const MKB_KEYWORDS = MKB_VARIABLES.concat(MKB_ACTIONS);
    // KEYWORD REGEX
    const KEYWORDS_RE = MKB_KEYWORDS.join(' ')
        .trim()
        .split(' ')
        .map(function(val) { return val.trim().split('|')[0]; })
        .join('|');

    const NUMBER = {
        scope:'number',
        className:'number',
        relevance: 0,
        begin:'-?[0-9](_?[0-9])*'
    };
    const DURATION = {
        scope:'number',
        className:'number',
        relevance: 1,
        begin:'[0-9](_?[0-9])*t|s|ms'
    };
    const OPERATORS = {
        scope:'operator',
        className:'operator',
        relevance: 0,
        begin:'==?|>=?|<=?|\\+|\\!=?|&&?|\\|\\|?|\\+|\\-|\\*|\\/|\\:='
    };
    const PUNCTUATION = {
        scope:'punctuation',
        className:'punctuation',
        relevance: 0,
        begin:';|:|\\(|\\+|\\)|\,'
    };
    const CUSTOM_ACTION = {
        scope:'title.function',
        className:'function',
        begin:'^[a-zA-Z0-9_-]+(?:\\n|;|\s)',
        endsParent: false,
        keywords: MKB_KEYWORDS
    }
    const VARIABLE = {
        scope:'variable',
        className:'variable',
        begin:'(?!\\$)@?(?:\&|#|)[a-zA-Z0-9_-]+',
        endsParent: false,
        relevance:0,
        contains:[NUMBER,CUSTOM_ACTION],
        keywords: MKB_KEYWORDS
    }
    const LITTERAL_VARIABLE = {
        scope:'variable',
        className:'variable',
        begin:'%',
        end:'%',
        excludeBegin: false,
        excludeEnd: false,
        contains:[]
    }
    const ARRAY = {
        scope:'variable',
        className:'variable',
        begin:'@?(?:\&|#|)[a-zA-Z0-9_-]+\\[',
        end:'\\]',
        excludeBegin: false,
        excludeEnd: false,
        endsParent: false,
        relevance:0,
        contains:[LITTERAL_VARIABLE]
    }
    ARRAY.contains.push(ARRAY);
    LITTERAL_VARIABLE.contains.push(ARRAY,VARIABLE);

    const STRING = {
        scope:'string',
        className:'string',
        begin:'"',
        end:'"',
        contains:[
            SUBST,
            ARRAY,
            LITTERAL_VARIABLE
        ]
    }
    const PARAMS = {
        scope:'params',
        className:'params',
        // begin:'\\(',
        // end:'\\)',
        begin:'^',
        excludeBegin: false,
        excludeEnd: false,
        endsParent: false,
        relevance:10,
        contains: [
            SUBST,
            STRING,
            OPERATORS,
            DURATION,
            NUMBER,
            ARRAY,
            VARIABLE,
            LITTERAL_VARIABLE
        ]
    }
    //
    const CONDITION = {
        scope:'title.function',
        className:'params',
        begin:'\\(',
        end:'\\)',
        relevance:0,
        endsParent: false,
        contains:[
            STRING,
            OPERATORS,
            DURATION,
            NUMBER,
            ARRAY,
            VARIABLE,
            LITTERAL_VARIABLE]
    }
    const PARAMS_WRAPPER = {
        scope:'params',
        className:'params',
        begin:'\\(',
        end:'\\)',
        endsParent: true,
        contains:[PARAMS]
    };
    CONDITION.contains.push(CONDITION,PARAMS_WRAPPER);
    const BOOLEANS = {
        // scope: 'literal',
        className: 'literal',
        begin: ['[a-z0-9_-]*?',
            '\\s*?=\\s*?',
            'true',
            'false'
        ],
        beginScope: {
            1: 'variable',
            2: 'operator',
            3: 'literal.true',
            4: 'literal.false'
        }
    }
    const ACTION = {
        scope:'title.function',
        className:'function',
        keywords: MKB_ACTIONS,
        // begin:'^[\t ]*?[a-zA-Z]',
        // begin:''+ACTIONS_RE,
        begin: '[a-zA-Z0-9_-]{1,}\\(',
        end:'\\)',
        excludeBegin: false,
        excludeEnd: false,
        returnBegin: false,
        relevance: 0,
        contains: [
            STRING,
            CONDITION,
            PARAMS_WRAPPER,
            DURATION,
            NUMBER,
            BOOLEANS,
            ARRAY,
            LITTERAL_VARIABLE,
            VARIABLE,
            OPERATORS,
        ]
    }

    return {
        name:'mkb',
        case_insensitive: true,
        keywords: MKB_KEYWORDS,
        illegal: '`|(?:%%)|(?:#{|})',
        contains: [
            hljs.COMMENT('//','$',
                {
                    relevance: 0
                }),
            SUBST,
            STRING,
            NUMBER,
            CONDITION,
            ACTION,
            PUNCTUATION,
            BOOLEANS,
            LITTERAL_VARIABLE,
            ARRAY,
            CUSTOM_ACTION,
            VARIABLE,
            OPERATORS
        ]
    };
}