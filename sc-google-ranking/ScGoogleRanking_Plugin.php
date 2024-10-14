<?php


include_once('ScGoogleRanking_LifeCycle.php');

class ScGoogleRanking_Plugin extends ScGoogleRanking_LifeCycle {

    /**
     * @return array of option meta data.
     */
    public function getOptionMetaData() {

        return array(
            //'_version' => array('Installed Version'), // Leave this one commented-out. Uncomment to test upgrades.
            //'YourURL' => array(__('Your URL', 'sc-google-ranking')),
            'YourKeywords' => array(__('Your Keywords', 'sc-google-ranking')),
            'GoogleDomain' => array(__('Google Domain', 'sc-google-ranking'),
		array('text'=>'United States (google.com)','value'=>'google.com'),
		array('text'=>'Australia (google.com.au)','value'=>'google.com.au'),
		array('text'=>'United Kingdom (google.co.uk)','value'=>'google.co.uk'),
		array('text'=>'China (google.com.hk)','value'=>'google.com.hk'),
		array('text'=>'Afghanistan (google.com.af)','value'=>'google.com.af'),
		array('text'=>'Albania (google.al)','value'=>'google.al'),
		array('text'=>'Algeria (google.dz)','value'=>'google.dz'),
		array('text'=>'American Samoa (google.as)','value'=>'google.as'),
		array('text'=>'Andorra (google.ad)','value'=>'google.ad'),
		array('text'=>'Angola (google.co.ao)','value'=>'google.co.ao'),
		array('text'=>'Anguilla (google.com.ai)','value'=>'google.com.ai'),
		array('text'=>'Antigua and Barbuda (google.com.ag)','value'=>'google.com.ag'),
		array('text'=>'Argentina (google.com.ar)','value'=>'google.com.ar'),
		array('text'=>'Armenia (google.am)','value'=>'google.am'),
		array('text'=>'Ascension Island (google.ac)','value'=>'google.ac'),
		array('text'=>'Austria (google.at)','value'=>'google.at'),
		array('text'=>'Azerbaijan (google.az)','value'=>'google.az'),
		array('text'=>'Bahamas (google.bs)','value'=>'google.bs'),
		array('text'=>'Bahrain (google.com.bh)','value'=>'google.com.bh'),
		array('text'=>'Bangladesh (google.com.bd)','value'=>'google.com.bd'),
		array('text'=>'Belarus (google.by)','value'=>'google.by'),
		array('text'=>'Belgium (google.be)','value'=>'google.be'),
		array('text'=>'Belize (google.com.bz)','value'=>'google.com.bz'),
		array('text'=>'Benin (google.bj)','value'=>'google.bj'),
		array('text'=>'Bhutan (google.bt)','value'=>'google.bt'),
		array('text'=>'Bolivia (google.com.bo)','value'=>'google.com.bo'),
		array('text'=>'Bosnia and Herzegovina (google.ba)','value'=>'google.ba'),
		array('text'=>'Botswana (google.co.bw)','value'=>'google.co.bw'),
		array('text'=>'Brazil (google.com.br)','value'=>'google.com.br'),
		array('text'=>'British Indian Ocean Territory (google.io)','value'=>'google.io'),
		array('text'=>'British Virgin Islands (google.vg)','value'=>'google.vg'),
		array('text'=>'Brunei (google.com.bn)','value'=>'google.com.bn'),
		array('text'=>'Bulgaria (google.bg)','value'=>'google.bg'),
		array('text'=>'Burkina Faso (google.bf)','value'=>'google.bf'),
		array('text'=>'Burma (google.com.mm)','value'=>'google.com.mm'),
		array('text'=>'Burundi (google.bi)','value'=>'google.bi'),
		array('text'=>'Cambodia (google.com.kh)','value'=>'google.com.kh'),
		array('text'=>'Cameroon (google.cm)','value'=>'google.cm'),
		array('text'=>'Canada (google.ca)','value'=>'google.ca'),
		array('text'=>'Cape Verde (google.cv)','value'=>'google.cv'),
		array('text'=>'CataloniaCatalan Countries (google.cat)','value'=>'google.cat'),
		array('text'=>'Central African Republic (google.cf)','value'=>'google.cf'),
		array('text'=>'Chad (google.td)','value'=>'google.td'),
		array('text'=>'Chile (google.cl)','value'=>'google.cl'),
		array('text'=>'Cocos (Keeling) Islands (google.cc)','value'=>'google.cc'),
		array('text'=>'Colombia (google.com.co)','value'=>'google.com.co'),
		array('text'=>'Cook Islands (google.co.ck)','value'=>'google.co.ck'),
		array('text'=>'Costa Rica (google.co.cr)','value'=>'google.co.cr'),
		array('text'=>'Croatia (google.hr)','value'=>'google.hr'),
		array('text'=>'Cuba (google.com.cu)','value'=>'google.com.cu'),
		array('text'=>'Cyprus (google.com.cy)','value'=>'google.com.cy'),
		array('text'=>'Czech Republic (google.cz)','value'=>'google.cz'),
		array('text'=>'Democratic Republic of the Congo (google.cd)','value'=>'google.cd'),
		array('text'=>'Denmark (google.dk)','value'=>'google.dk'),
		array('text'=>'Djibouti (google.dj)','value'=>'google.dj'),
		array('text'=>'Dominica (google.dm)','value'=>'google.dm'),
		array('text'=>'Dominican Republic (google.com.do)','value'=>'google.com.do'),
		array('text'=>'Ecuador (google.com.ec)','value'=>'google.com.ec'),
		array('text'=>'Egypt (google.com.eg)','value'=>'google.com.eg'),
		array('text'=>'El Salvador (google.com.sv)','value'=>'google.com.sv'),
		array('text'=>'Estonia (google.ee)','value'=>'google.ee'),
		array('text'=>'Ethiopia (google.com.et)','value'=>'google.com.et'),
		array('text'=>'Federated States of Micronesia (google.fm)','value'=>'google.fm'),
		array('text'=>'Fiji (google.com.fj)','value'=>'google.com.fj'),
		array('text'=>'Finland (google.fi)','value'=>'google.fi'),
		array('text'=>'France (google.fr)','value'=>'google.fr'),
		array('text'=>'French Guiana (google.gf)','value'=>'google.gf'),
		array('text'=>'Gabon (google.ga)','value'=>'google.ga'),
		array('text'=>'Gambia (google.gm)','value'=>'google.gm'),
		array('text'=>'Georgia (google.ge)','value'=>'google.ge'),
		array('text'=>'Germany (google.de)','value'=>'google.de'),
		array('text'=>'Germany (google.de)','value'=>'google.de'),
		array('text'=>'Ghana (google.com.gh)','value'=>'google.com.gh'),
		array('text'=>'Gibraltar (google.com.gi)','value'=>'google.com.gi'),
		array('text'=>'Greece (google.gr)','value'=>'google.gr'),
		array('text'=>'Greenland (google.gl)','value'=>'google.gl'),
		array('text'=>'Guadeloupe (google.gp)','value'=>'google.gp'),
		array('text'=>'Guatemala (google.com.gt)','value'=>'google.com.gt'),
		array('text'=>'Guernsey (google.gg)','value'=>'google.gg'),
		array('text'=>'Guyana (google.gy)','value'=>'google.gy'),
		array('text'=>'Haiti (google.ht)','value'=>'google.ht'),
		array('text'=>'Honduras (google.hn)','value'=>'google.hn'),
		array('text'=>'Hong Kong (google.com.hk)','value'=>'google.com.hk'),
		array('text'=>'Hungary (google.hu)','value'=>'google.hu'),
		array('text'=>'Iceland (google.is)','value'=>'google.is'),
		array('text'=>'India (google.co.in)','value'=>'google.co.in'),
		array('text'=>'Indonesia (google.co.id)','value'=>'google.co.id'),
		array('text'=>'Iran (google.ir)','value'=>'google.ir'),
		array('text'=>'Iraq (google.iq)','value'=>'google.iq'),
		array('text'=>'Ireland (google.ie)','value'=>'google.ie'),
		array('text'=>'Isle of Man (google.im)','value'=>'google.im'),
		array('text'=>'Israel (google.co.il)','value'=>'google.co.il'),
		array('text'=>'Italy (google.it)','value'=>'google.it'),
		array('text'=>'Ivory Coast (google.ci)','value'=>'google.ci'),
		array('text'=>'Jamaica (google.com.jm)','value'=>'google.com.jm'),
		array('text'=>'Japan (google.co.jp)','value'=>'google.co.jp'),
		array('text'=>'Jersey (google.je)','value'=>'google.je'),
		array('text'=>'Jordan (google.jo)','value'=>'google.jo'),
		array('text'=>'Kazakhstan (google.kz)','value'=>'google.kz'),
		array('text'=>'Kenya (google.co.ke)','value'=>'google.co.ke'),
		array('text'=>'Kiribati (google.ki)','value'=>'google.ki'),
		array('text'=>'Kuwait (google.com.kw)','value'=>'google.com.kw'),
		array('text'=>'Kyrgyzstan (google.kg)','value'=>'google.kg'),
		array('text'=>'Laos (google.la)','value'=>'google.la'),
		array('text'=>'Latvia (google.lv)','value'=>'google.lv'),
		array('text'=>'Lebanon (google.com.lb)','value'=>'google.com.lb'),
		array('text'=>'Lesotho (google.co.ls)','value'=>'google.co.ls'),
		array('text'=>'Libya (google.com.ly)','value'=>'google.com.ly'),
		array('text'=>'Liechtenstein (google.li)','value'=>'google.li'),
		array('text'=>'Lithuania (google.lt)','value'=>'google.lt'),
		array('text'=>'Luxembourg (google.lu)','value'=>'google.lu'),
		array('text'=>'Macedonia (google.mk)','value'=>'google.mk'),
		array('text'=>'Madagascar (google.mg)','value'=>'google.mg'),
		array('text'=>'Malawi (google.mw)','value'=>'google.mw'),
		array('text'=>'Malaysia (google.com.my)','value'=>'google.com.my'),
		array('text'=>'Maldives (google.mv)','value'=>'google.mv'),
		array('text'=>'Mali (google.ml)','value'=>'google.ml'),
		array('text'=>'Malta (google.com.mt)','value'=>'google.com.mt'),
		array('text'=>'Mauritius (google.mu)','value'=>'google.mu'),
		array('text'=>'Mexico (google.com.mx)','value'=>'google.com.mx'),
		array('text'=>'Moldova (google.md)','value'=>'google.md'),
		array('text'=>'Mongolia (google.mn)','value'=>'google.mn'),
		array('text'=>'Montenegro (google.me)','value'=>'google.me'),
		array('text'=>'Montserrat (google.ms)','value'=>'google.ms'),
		array('text'=>'Morocco (google.co.ma)','value'=>'google.co.ma'),
		array('text'=>'Mozambique (google.co.mz)','value'=>'google.co.mz'),
		array('text'=>'Namibia (google.com.na)','value'=>'google.com.na'),
		array('text'=>'Nauru (google.nr)','value'=>'google.nr'),
		array('text'=>'Nepal (google.com.np)','value'=>'google.com.np'),
		array('text'=>'Netherlands (google.nl)','value'=>'google.nl'),
		array('text'=>'New Zealand (google.co.nz)','value'=>'google.co.nz'),
		array('text'=>'Nicaragua (google.com.ni)','value'=>'google.com.ni'),
		array('text'=>'Niger (google.ne)','value'=>'google.ne'),
		array('text'=>'Nigeria (google.com.ng)','value'=>'google.com.ng'),
		array('text'=>'Niue (google.nu)','value'=>'google.nu'),
		array('text'=>'Norfolk Island (google.com.nf)','value'=>'google.com.nf'),
		array('text'=>'Norway (google.no)','value'=>'google.no'),
		array('text'=>'Oman (google.com.om)','value'=>'google.com.om'),
		array('text'=>'Pakistan (google.com.pk)','value'=>'google.com.pk'),
		array('text'=>'Palestine[4] (google.ps)','value'=>'google.ps'),
		array('text'=>'Panama (google.com.pa)','value'=>'google.com.pa'),
		array('text'=>'Papua New Guinea (google.com.pg)','value'=>'google.com.pg'),
		array('text'=>'Paraguay (google.com.py)','value'=>'google.com.py'),
		array('text'=>'Peru (google.com.pe)','value'=>'google.com.pe'),
		array('text'=>'Philippines (google.com.ph)','value'=>'google.com.ph'),
		array('text'=>'Pitcairn Islands (google.pn)','value'=>'google.pn'),
		array('text'=>'Poland (google.pl)','value'=>'google.pl'),
		array('text'=>'Portugal (google.pt)','value'=>'google.pt'),
		array('text'=>'Puerto Rico (google.com.pr)','value'=>'google.com.pr'),
		array('text'=>'Qatar (google.com.qa)','value'=>'google.com.qa'),
		array('text'=>'Republic of the Congo (google.cg)','value'=>'google.cg'),
		array('text'=>'Romania (google.ro)','value'=>'google.ro'),
		array('text'=>'Russia (google.ru)','value'=>'google.ru'),
		array('text'=>'Rwanda (google.rw)','value'=>'google.rw'),
		array('text'=>'Saint Helena, Ascension and Tristan da Cunha (google.sh)','value'=>'google.sh'),
		array('text'=>'Saint Lucia (google.com.lc)','value'=>'google.com.lc'),
		array('text'=>'Saint Vincent and the Grenadines (google.com.vc)','value'=>'google.com.vc'),
		array('text'=>'Samoa (google.ws)','value'=>'google.ws'),
		array('text'=>'San Marino (google.sm)','value'=>'google.sm'),
		array('text'=>'São Tomé and Príncipe (google.st)','value'=>'google.st'),
		array('text'=>'Saudi Arabia (google.com.sa)','value'=>'google.com.sa'),
		array('text'=>'Senegal (google.sn)','value'=>'google.sn'),
		array('text'=>'Serbia (google.rs)','value'=>'google.rs'),
		array('text'=>'Seychelles (google.sc)','value'=>'google.sc'),
		array('text'=>'Sierra Leone (google.com.sl)','value'=>'google.com.sl'),
		array('text'=>'Singapore (google.com.sg)','value'=>'google.com.sg'),
		array('text'=>'Slovakia (google.sk)','value'=>'google.sk'),
		array('text'=>'Slovenia (google.si)','value'=>'google.si'),
		array('text'=>'Solomon Islands (google.com.sb)','value'=>'google.com.sb'),
		array('text'=>'Somalia (google.so)','value'=>'google.so'),
		array('text'=>'South Africa (google.co.za)','value'=>'google.co.za'),
		array('text'=>'South Korea (google.co.kr)','value'=>'google.co.kr'),
		array('text'=>'Spain (google.es)','value'=>'google.es'),
		array('text'=>'Sri Lanka (google.lk)','value'=>'google.lk'),
		array('text'=>'Sweden (google.se)','value'=>'google.se'),
		array('text'=>'Switzerland (google.ch)','value'=>'google.ch'),
		array('text'=>'Taiwan (google.com.tw)','value'=>'google.com.tw'),
		array('text'=>'Tajikistan (google.com.tj)','value'=>'google.com.tj'),
		array('text'=>'Tanzania (google.co.tz)','value'=>'google.co.tz'),
		array('text'=>'Thailand (google.co.th)','value'=>'google.co.th'),
		array('text'=>'Timor-Leste (google.tl)','value'=>'google.tl'),
		array('text'=>'Togo (google.tg)','value'=>'google.tg'),
		array('text'=>'Tokelau (google.tk)','value'=>'google.tk'),
		array('text'=>'Tonga (google.to)','value'=>'google.to'),
		array('text'=>'Trinidad and Tobago (google.tt)','value'=>'google.tt'),
		array('text'=>'Tunisia (google.tn)','value'=>'google.tn'),
		array('text'=>'Tunisia (google.com.tn)','value'=>'google.com.tn'),
		array('text'=>'Turkey (google.com.tr)','value'=>'google.com.tr'),
		array('text'=>'Turkmenistan (google.tm)','value'=>'google.tm'),
		array('text'=>'Uganda (google.co.ug)','value'=>'google.co.ug'),
		array('text'=>'Ukraine (google.com.ua)','value'=>'google.com.ua'),
		array('text'=>'United Arab Emirates (google.ae)','value'=>'google.ae'),
		array('text'=>'United States Virgin Islands (google.co.vi)','value'=>'google.co.vi'),
		array('text'=>'Uruguay (google.com.uy)','value'=>'google.com.uy'),
		array('text'=>'Uzbekistan (google.co.uz)','value'=>'google.co.uz'),
		array('text'=>'Vanuatu (google.vu)','value'=>'google.vu'),
		array('text'=>'Venezuela (google.co.ve)','value'=>'google.co.ve'),
		array('text'=>'Vietnam (google.com.vn)','value'=>'google.com.vn'),
		array('text'=>'Zambia (google.co.zm)','value'=>'google.co.zm'),
		array('text'=>'Zimbabwe (google.co.zw)','value'=>'google.co.zw')		
            )
        );
    }

//    protected function getOptionValueI18nString($optionValue) {
//        $i18nValue = parent::getOptionValueI18nString($optionValue);
//        return $i18nValue;
//    }

    protected function initOptions() {
        $options = $this->getOptionMetaData();
        if (!empty($options)) {
            foreach ($options as $key => $arr) {
                if (is_array($arr) && count($arr > 1)) {
                    $this->addOption($key, $arr[1]);
                }
            }
        }
    }

    public function getPluginDisplayName() {
        return 'SC Google Page Rank';
    }

    protected function getMainPluginFileName() {
        return 'sc-google-ranking.php';
    }

    /**
     * Called by install() to create any database tables if needed.
     * Best Practice:
     * (1) Prefix all table names with $wpdb->prefix
     * (2) make table names lower case only
     * @return void
     */
    protected function installDatabaseTables() {
        //        global $wpdb;
        //        $tableName = $this->prefixTableName('mytable');
        //        $wpdb->query("CREATE TABLE IF NOT EXISTS `$tableName` (
        //            `id` INTEGER NOT NULL");
    }

    /**
     * See: http://plugin.michael-simpson.com/?page_id=101
     * Drop plugin-created tables on uninstall.
     * @return void
     */
    protected function unInstallDatabaseTables() {
        //        global $wpdb;
        //        $tableName = $this->prefixTableName('mytable');
        //        $wpdb->query("DROP TABLE IF EXISTS `$tableName`");
    }


    /**
     * Perform actions when upgrading from version X to version Y
     * @return void
     */
    public function upgrade() {
    }

    public function addActionsAndFilters() {

        // Add options administration page

        add_action('admin_menu', array(&$this, 'createSettingsMenu'));

                if (strpos($_SERVER['REQUEST_URI'], $this->getSettingsSlug()) !== false) {
        //            wp_enqueue_script('my-script', plugins_url('/js/my-script.js', __FILE__));
        //            wp_enqueue_style('style', plugins_url('/css/sc-styles.css', __FILE__));
                }


        // Add Actions & Filters



        // Adding scripts & styles to all pages
        // Examples:
        //        wp_enqueue_script('jquery');
                wp_enqueue_style('my-style', plugins_url('/css/sc-styles.css', __FILE__));
        //        wp_enqueue_script('my-script', plugins_url('/js/my-script.js', __FILE__));


        // Register short codes



        // Register AJAX hooks


    }


}