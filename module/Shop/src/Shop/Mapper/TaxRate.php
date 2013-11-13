<?php
namespace Shop\Mapper;

use Application\Mapper\AbstractMapper;

class TaxRate extends AbstractMapper
{
	protected $table = 'taxRate';
	protected $primary = 'taxRateId';
	protected $model = 'Shop\Model\TaxRate';
	protected $hydrator = 'Shop\Hydrator\TaxRate';
	
	/**
	 *  SELECT cost, post_level, vat_inc, tax_rate
FROM countries, post_zones, post_cost, post_level, tax_codes, tax_rates
WHERE countries.country_id=$CountryCode
AND countries.post_zone_id=post_zones.post_zone_id
AND post_cost.post_level_id=post_level.post_level_id
AND post_zones.tax_code_id=tax_codes.tax_code_id
AND post_zones.post_zone_id=post_cost.post_zone_id
AND tax_codes.tax_rate_id=tax_rates.tax_rate_id
ORDER BY post_level ASC
	 * @param unknown $code
	 */
	public function getTaxRateByCountryCode($code)
	{
	    
	}
	
}
