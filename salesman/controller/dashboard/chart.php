<?php
class ControllerDashboardChart extends Controller {
	public function index() {
		$this->load->language('dashboard/chart');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_day'] = $this->language->get('text_day');
		$data['text_week'] = $this->language->get('text_week');
		$data['text_month'] = $this->language->get('text_month');
		$data['text_year'] = $this->language->get('text_year');
		$data['text_view'] = $this->language->get('text_view');

		$data['token'] = $this->session->data['token'];
		$data['salesman_id'] = $this->salesman->getId();

		if (isset($this->request->get['filter_period_from'])) {
			$filter_date_start = $this->request->get['filter_period_from'];
		} else {
			$filter_date_start= null;
		}
		
		if (isset($this->request->get['filter_period_to'])) {
			$filter_date_end = $this->request->get['filter_period_to'];
		} else {
			$filter_date_end= null;
		}

		$data['filter_period_from'] = $filter_date_start;
		$data['filter_period_to'] = $filter_date_end;

		return $this->load->view('dashboard/chart.tpl', $data);
	}

	public function chart() {

		$this->load->language('dashboard/chart');

		$json = array();
		
		$this->load->model('finance/order_commissions');

		$json['order']  = array();
		$json['sale']  = array();
		$json['commission']  = array();
		$json['xaxis']  = array();
		
		$json['order']['label'] = $this->language->get('text_order');
		$json['sale']['label'] = $this->language->get('text_sale');
		$json['commission']['label'] = $this->language->get('text_commission');
		
		$json['order']['data'] = array();
		$json['sale']['data'] = array();
		$json['commission']['data'] = array();
		
		// Filter
		if (isset($this->request->get['filter_period_from'])) {
			$filter_date_start = $this->request->get['filter_period_from'];
		} else {
			$filter_date_start= null;
		}
		
		if (isset($this->request->get['filter_period_to'])) {
			$filter_date_end = $this->request->get['filter_period_to'];
		} else {
			$filter_date_end= null;
		}

		$data = array(
			'filter_date_start'          => $filter_date_start,
			'filter_date_end'            => $filter_date_end,
			'filter_commissions_status'  => null, 
			'salesman_id'                => $this->salesman->getId()
		);

		$results = $this->model_finance_order_commissions->getOrderCommissions($data);

		if(empty($filter_date_end)) {
			$filter_date_end = date('Y-m-d');
		}

		if(!empty($results)) {
			$first_day = $this->getFirstDayOfMonth($results[0]['date']);

			if(strtotime($first_day) == strtotime($this->getFirstDayOfMonth($filter_date_end))) {

				// init the jason data struct.
				for ($i = strtotime($first_day), $j = 0; $i <= strtotime($filter_date_end);
					$i = strtotime('+1 Day', $i), $j++) {

					$json['order']['data'][] = array($j, 0);
					$json['sale']['data'][] = array($j, 0);
					$json['commission']['data'][] = array($j, 0);

					$json['xaxis'][] = array($j, date('d', $i));
				}


				// generate data by day
				$last_day = "";
				$key = 0;
				$sum_order = 0;
				$sum_sale = 0;
				$sum_comm = 0;
				foreach($results as $result) {
					if(empty($last_day)) {
						$key = (strtotime($result['date']) - strtotime($first_day)) / 86400;
					}

					if(empty($last_day) ||
						strtotime($result['date']) == strtotime($last_day)) {
						$sum_order = $sum_order + $result['order_num'];
						$sum_sale = $sum_sale + $result['order_total'];
						$sum_comm = $sum_comm + $result['commissions_total'];
					} else {
						$json['order']['data'][$key] = array($key, $sum_order);
						$json['sale']['data'][$key] = array($key, $sum_sale);
						$json['commission']['data'][$key] = array($key, $sum_comm);

						$key = (strtotime($result['date']) - strtotime($first_day)) / 86400;

						$sum_order = $result['order_num'];
						$sum_sale = $result['order_total'];
						$sum_comm = $result['commissions_total'];
					}

					$last_day = $result['date'];
				}

				$json['order']['data'][$key] = array($key, $sum_order);
				$json['sale']['data'][$key] = array($key, $sum_sale);
				$json['commission']['data'][$key] = array($key, $sum_comm);

			} else {

				// init the jason data struct.
				for ($i = strtotime($first_day), $j = 0; 
					$i <= strtotime($this->getFirstDayOfMonth($filter_date_end));
					$i = strtotime('+1 Month', $i), $j++) {

					$json['order']['data'][] = array($j, 0);
					$json['sale']['data'][] = array($j, 0);
					$json['commission']['data'][] = array($j, 0);

					$json['xaxis'][] = array($j, date('Y-m', $i));
				}

				// generate data by month 
				$last_day = "";
				$key = 0;
				$sum_order = 0;
				$sum_sale = 0;
				$sum_comm = 0;
				foreach($results as $result) {
					if(empty($last_day)) {
						$key = $this->getMonthDiff($result['date'], $first_day); 
					}

					if(empty($last_day) ||
						strtotime($this->getFirstDayOfMonth($result['date'])) == strtotime($this->getFirstDayOfMonth($last_day))) {
						$sum_order = $sum_order + $result['order_num'];
						$sum_sale = $sum_sale + $result['order_total'];
						$sum_comm = $sum_comm + $result['commissions_total'];
					} else {
						$json['order']['data'][$key] = array($key, $sum_order);
						$json['sale']['data'][$key] = array($key, $sum_sale);
						$json['commission']['data'][$key] = array($key, $sum_comm);

						$key = $this->getMonthDiff($result['date'], $this->getFirstDayOfMonth($first_day)); 

						$sum_order = $result['order_num'];
						$sum_sale = $result['order_total'];
						$sum_comm = $result['commissions_total'];
					}

					$last_day = $result['date'];
				}

				$json['order']['data'][$key] = array($key, $sum_order);
				$json['sale']['data'][$key] = array($key, $sum_sale);
				$json['commission']['data'][$key] = array($key, $sum_comm);

			}
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));

	}

	/**
	 * @var1: string of date.
	 * @var2: string of date.
	 * @var3: decollator of date, default as '' 
	 */
	private function getMonthDiff($date1, $date2, $tags='-') {
		$time1 = strtotime($date1);
		$time2 = strtotime($date2);
		$date1 = explode($tags, $date1);
		$date2 = explode($tags, $date2);
		$months =abs($date1[0] - $date2[0]) * 12;
		if($time1 > $time2) {
			return $months + $date1[1] - $date2[1];
		} else {
			return - ($months + $date2[1] - $date1[1]);
		}
	}

	/**
	 * @var1: string of date.
	 */
	private function getFirstDayOfMonth($date) {
		return date('Y-m-01', strtotime($date));
	}
}
