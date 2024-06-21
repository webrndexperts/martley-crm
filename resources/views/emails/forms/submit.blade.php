<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title></title>
	</head>
	<body>
		<div id="" dir="ltr" style="background-color:#f9f9f9;margin:0;padding:70px 0;width:100%;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif">
			<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
				<tbody>
					<tr>
						<td align="center" valign="top">
							<div id=""></div>
							<table border="0" cellpadding="0" cellspacing="0" width="600" id="container"
							style="background-color:#fff;border:1px solid #e0e0e0;border-radius:3px">
								<tbody>
									<tr>
										<td align="center" valign="top">
											<p style="margin-top: 50px;margin-bottom: 0;">
												<img src="{{ url('public/new/img/logo.png') }}" alt="logo" style="border: 1px solid #bc9c23;" />
											</p>
										</td>
									</tr>
									<tr>
										<td style="
											text-align: center;
											padding: 30px 30px 0;
										">
											<h2>Hello!</h2>
											<p>I hope this message finds you well.</p>

											@if($answers && count($answers) > 0)
												<p>I am writing to inform you that <b>{{ $answers[0]->user->name }}</b> has successfully completed and submitted the <b>{{ $form->name }}</b> form. The form has been reviewed and is attached to this email for your records and further processing.</p>
											@endif
										</td>
									</tr>

									@if($answers && count($answers) > 0)
										<tr>
											<td align="center" valign="top">
												<table border="0" cellpadding="0" cellspacing="0" width="600" id="">
													<tbody>
														<tr>
															<td valign="top" id="" style="background-color:#fff">
																<table border="0" cellpadding="20" cellspacing="0" width="100%">
																	<tbody>
																		<tr>
																			<td valign="top" style="padding:30px 30px 0px">
																				<div id="" style="color:#636363;font-size:14px;line-height:150%">
																					<div>
																						<table cellspacing="0" cellpadding="6"
																						border="1"
																						style="color:#636363;border:1px solid #e5e5e5;width:100%; width:100%;font-size: 14px">
																							<tfoot style="color:#636363;text-align: left !important;font-size: 14px">
																								@foreach($answers as $k => $answer)
																									<tr>
																										<th scope="row" colspan="2" style="border:1px solid #e5e5e5;padding:12px">
																											{{ $answer->question->label }}:
																										</th>
																										<td style="border:1px solid #e5e5e5;padding:12px">
																											@if($answer->question->type == 'file')
																												<a style="color: #3361FF" href="{{ $answer->answer }}" target="_blank">View</a>
																											@else
																												{{ $answer->answer }}
																											@endif
																										</td>
																									</tr>
																								@endforeach
																							</tfoot>
																						</table>
																					</div>
																				</div>
																			</td>
																		</tr>
																	</tbody>
																</table>
															</td>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>
									@endif

									<tr>
										<td style="
											text-align: center;
											padding: 30px 30px 40px;
										">
											<p>Please let me know if you need any additional information or if there are any further steps required.</p>

											<p>Thank you for your attention to this matter. <a href="{{ url('/') }}" style="color: #bc9c23; text-decoration: none;">Visit our site</a>
											</p>
										</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</body>
</html>