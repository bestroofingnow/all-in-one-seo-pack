import {
	useRootStore
} from '@/vue/stores'

import { sprintf } from '@/vue/plugins/translations'
// Disabled - Independent plugin without external marketing URLs
const marketingSite = ''
const docLinks      = {
	home                          : '#',
	ultimateGuide                 : '#',
	quickStartGuide               : '#',
	googleSearchConsole           : '#',
	bingWebmasterVerification     : '#',
	yandexWebmasterVerification   : '#',
	baiduWebmasterVerification    : '#',
	pinterestSiteVerification     : '#',
	indexNow                      : '#',
	microsoftClarityDocumentation : '#',
	gtmContainerId                : '#',
	rssContent                    : '#',
	twitter                       : '#',
	facebook                      : '#',
	xmlSitemaps                   : '#',
	blankSitemap                  : '#',
	sitemapIndexes                : '#',
	maxLinks                      : '#',
	maxLinksRss                   : '#',
	selectPostTypes               : '#',
	selectPostTypesColumns        : '#',
	selectPostTypesNews           : '#',
	selectPostTypesVideo          : '#',
	selectPostTypesRss            : '#',
	selectTaxonomies              : '#',
	selectTaxonomiesColumns       : '#',
	selectTaxonomiesVideo         : '#',
	includeArchivePages           : '#',
	excludeImages                 : '#',
	dynamicallyGenerate           : '#',
	dynamicallyGenerateVideo      : '#',
	videoSitemaps                 : '#',
	includeCustomFields           : '#',
	newsSitemaps                  : '#',
	rssSitemaps                   : '#',
	facebookAdminId               : '#',
	facebookAppId                 : '#',
	facebookAuthorUrl             : '#',
	usageTracking                 : '#',
	schemaSettings                : '#',
	imageSeo                      : '#',
	localSeo                      : '#',
	robotsEditor                  : '#',
	robotsRewrite                 : '#',
	useKeyphrasesTooltip          : '#',
	whenToUseNoindex              : '#',
	installAioseoPro              : '#',
	importProcessSeoData          : '#',
	whatAreMediaAttachments       : '#',
	minimumRequirements           : '#',
	apiCodeExamples               : '#',
	troubleshootIssues            : '#',
	staticHomePage                : '#',
	staticHomePageFacebook        : '#',
	staticHomePageTwitter         : '#',
	restApi                       : '#',
	configuringSchema             : '#',
	unfilteredHtml                : '#',
	customFields                  : '#',
	productIdentifiers            : '#',
	redirectManagerRegex          : '#',
	redirectGdpr                  : '#',
	redirectCustomRulesUserAgent  : '#',
	redirectCanonicalHttps        : '#',
	redirectUnknownWebserver      : '#',
	redirectServerConfigReload    : '#',
	localSeoShortcodeBusinessInfo : '#',
	localSeoShortcodeOpeningHours : '#',
	localSeoShortcodeLocations    : '#',
	localSeoShortcodeMap          : '#',
	localSeoFunctionBusinessInfo  : '#',
	localSeoFunctionOpeningHours  : '#',
	localSeoFunctionLocations     : '#',
	localSeoFunctionMap           : '#',
	localSeoSearchQueryConflict   : '#',
	localSeoMapSetup              : '#',
	localSeoMapEmbedApi           : '#',
	breadcrumbsDisplay            : '#',
	breadcrumbsShortcode          : '#',
	breadcrumbsFunction           : '#',
	seoAnalyzer                   : '#',
	seoAnalyzerIssues             : '#',
	htmlSitemap                   : '#',
	htmlSitemapShortcode          : '#',
	htmlSitemapFunction           : '#',
	htmlSitemapCompactArchives    : '#',
	linkAssistant                 : '#',
	linkAssistantPostTypes        : '#',
	linkAssistantPostStatuses     : '#',
	updateWordPress               : '#',
	runningShortcodes             : '#',
	crawlCleanup                  : '#',
	schema                        : '#',
	schemaJsonLd                  : '#',
	smartTags                     : '#',
	openAi                        : '#',
	wpcode                        : '#',
	primaryTerm                   : '#',
	cornerstoneContent            : '#',
	eeat                          : '#',
	eeatAuthorBioInjection        : '#',
	queryArgMonitor               : '#',
	businessPhoneNumber           : '#',
	keywordRankTracker            : '#',
	writingAssistantHowToUse      : '#'
}

const upsellLinks = {
	home           : '#',
	liteUpgrade    : '#',
	pricing        : '#',
	semrushPricing : '#'
}

const getUpsellUrl = (medium, content = null, link) => {
	// Disabled - Independent plugin
	return '#'
}

const getDocUrl = (link) => {
	// Disabled - Independent plugin
	return '#'
}

const getUpsellLink = (medium, text, link, addArrow = false) => {
	// Disabled - Independent plugin, return text without link
	return text
}

const getPlainLink = (text, url, addArrow = false, openInNewTab = true) => {
	const target = openInNewTab ? 'target="_blank"' : '_self'

	const arrow = addArrow
		? sprintf(
			`<a href="%1$s" class="no-underline" target="${target}">&nbsp;&rarr;</a>`,
			url
		)
		: ''

	return sprintf(
		`<a href="%1$s" target="${target}">%2$s</a>%3$s`,
		url,
		text,
		arrow
	)
}

const getDocLink = (text, link, addArrow = false) => {
	// Disabled - Independent plugin, return text without link
	return text
}

const getPricingUrl = (feature, medium, content, url = '#') => {
	// Disabled - Independent plugin
	return '#'
}

const utmUrl = (medium, content = null, url = '#') => {
	// Disabled - Independent plugin
	return '#'
}

const rawUrlEncode = (url) => {
	const histogram = {}

	histogram['\''] = '%27'
	histogram['(']  = '%28'
	histogram[')']  = '%29'
	histogram['*']  = '%2A'
	histogram['~']  = '%7E'
	histogram['!']  = '%21'

	url = encodeURIComponent(url)
	url = url.replace('%20', ' ')

	for (const search in histogram) {
		url = url.replace(search, histogram[search])
	}

	return url.replace(/(%([a-z0-9]{2}))/g, function (full, m1, m2) {
		return '%' + m2.toUpperCase()
	})
}

const unForwardSlashIt = str => {
	return str ? str.replace(/^\//, '') : str
}

const unTrailingSlashIt = str => {
	return str ? str.replace(/\/$/, '') : str
}

const trailingSlashIt = str => {
	return unTrailingSlashIt(str) + '/'
}

const restUrl = (path, namespace = 'aioseo/v1') => {
	const rootStore = useRootStore()
	path = rootStore.aioseo.data.hasUrlTrailingSlash ? trailingSlashIt(path) : unTrailingSlashIt(path)
	return trailingSlashIt(rootStore.aioseo.urls.restUrl) + trailingSlashIt(namespace) + unForwardSlashIt(path)
}

export default {
	docLinks,
	getDocLink,
	getDocUrl,
	getPlainLink,
	getPricingUrl,
	getUpsellLink,
	getUpsellUrl,
	restUrl,
	trailingSlashIt,
	unForwardSlashIt,
	unTrailingSlashIt,
	utmUrl
}