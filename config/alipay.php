<?php

return [	
		//应用ID,您的APPID。
		'app_id' => "2016092900620874",

		//商户私钥
		'merchant_private_key' => "MIIEogIBAAKCAQEAtgX4h9oUVD3DPiMQCpGISXfxqtB0/P1q6fhiaTDmQubj28IPiX1bUbHgIGhGvey9lQNLlEV4Up2U9VZ3/Jg5i/uBsexRnmKuRU7jBKbQsIyCgQZgVzZpgUQqCdwZJQuRZ3OyfV73X9lApGRYIitCdOOU0ywnrMeQDFoKZcJMtb6h8Re0k6DHrBbbbvSvCFnls0jvyBTY+cGIuv/A+LpDJb1YpvmmZJUYX5o487dJpX+HT25oVafUnu+qv6+3JptSy8AJKwSwqE2rcEgwRhJikcsCe29EACqi4uk0+bR7hJQLaxnbHnhPGYuBA5SEbCJgXvJqvWIcHlTtNsDvy5owbQIDAQABAoIBAAW12j4o0UpzRZTFdNNgDW6AnMxHDeSB7sC4Uh4Ksq6Wn79dLy+ZByxg8C8UFmQO8UOjftN/+m5dEzc/JzR9chC6Ky9xwn29isoR131l3lYrkkyJ7qvNwTGU+dylUwSegElGj+ru98PCBQ0jOMCZqtQP77NQR05cVGCO0pSuq8lnzA46pnsal3y4exu4vDWLW9dc13TqX62hlQJoP0vSJIDrmcsQ7BIBoEEbbTAOxpJedImIoi5i+iZcohH8MLXNQcDV/CKOHwo5WnCcrBgTgV2pwyEOQ+d7cyUmU912jS9unvaUrU8ZA5XW0b04PyCqIQh5lhhJUerNVTghpJn64+ECgYEA4WG91V8QaOlUnRQIsIDh9U1Px5SNlSBI8QZLKrZFWnZdhv3j1+NN28urjxNgxbRIviHc2KXU29JFhI4aSh9jnJX3mnN1PVizOj39/LgEgwCC9RoEjpC97+GMKDNsMtduPvazdtmUfaOQXn5gWzCeIXKZ9J2dlPvJyTAAdXm6AasCgYEAzsBSUAuXBTJTsmBrgTvRapS0kpDvSNRVZmZauZzsZs88ngdgn1K/e/0Pv1tcqabgQrRlRRnD9qP5yLtDaMu0R+ElcqJcc0SY3YcR1VRUauCUp20yTx3S+KiGwpcqEiQ08Km8kZ6/n8xX01Mmq5v7kUaqUgfvFg+1+INoOx0lLkcCgYBLgNX6nB1AOCKbeLGsh5Cq/9phLvf7ZFRrQkN+LI+xTYPpjDZ/BWv43RM9HC3ILaxM3cVBYtSbS6b0UDKocDmLpIXNXS6CfauVMF1dAzynsk0s1Sl/pSesK/ArK4bsxVTujPD0ONHRATGFJmsbQX9IDz9aPk8jMPKZjpYoxL22fwKBgF/Akl6f/4FYnYqvPRrNKV/DHx4CIdAJBsQ2Ay6TjqjOsbQ+lnEzUZuKyBBHr9KihppeEci+9hL0PmrIz59pOEVR8JX2u/pmeqWeOJQkSjR1bmNcH0Ck/2BKLJ9SgxmDy0DqW3rVmsnXSZWFnRM9WnUd1SPIqOH+xLgjo9I83UthAoGAdddvGRYYSmdsmP0U5C37mmV46SYSlemb2qCWmh0T/wQrr54gCVfrNoChS3gXMPf3vSEhRtG6bpbntjUSz/8y95/qV/y0ysoLhp2KdA95xVE3/GIeNR3ldaAXPtM9hgixfseAgAMbdoaBRcz1O8hHIYdqvL9Jch67lyu8i+XANHs=",
		
		//异步通知地址
		'notify_url' => "http://39.107.75.63",
		
		//同步跳转
		'return_url' => "http://return_url.php",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAyOsizgmZekCHdV3P571m+0MBkQyGmcpuj5oUYzZG7svbCWvop045id+O+yj8d+tajj9b53pwHh1QS75E8DJUeYDdQ2l/X1dQZ7p3ZNDgRoJMMiKGUPRXRdg9Lh505cN+DDOEDOnYWLBsHGBvGAeDBkJw8CsoNGvjDvPwA/8uDueWxeRGkYFMV7AQyF7+i91n8mcqzXteyz5gdG+Q62W4Ui25vbgjexgX+Ugv5G2ghelJAQB5UTtX5OqC1xFWWms4opw04h6eUC6ZVickOI4CkDxHj1xa3sav1R0e/HeMjTK+nPRCgbJngspR6Cbiqgne47Jvfm/2bF34DZdjsrAuKQIDAQAB",
];