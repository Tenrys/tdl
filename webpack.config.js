const path = require("path");
const VueLoaderPlugin = require("vue-loader/lib/plugin");

module.exports = {
	entry: "./js/index.js",
	output: {
		filename: "./bundle.js",
		path: __dirname,
	},
	module: {
		rules: [
			{
				test: /\.js$/,
				exclude: /(node_modules|bower_components)/,
				loader: "babel-loader",
			},
			{
				test: /\.css$/,
				use: ["vue-style-loader", "css-loader"],
			},
			{
				test: /\.vue$/,
				loader: "vue-loader",
			},
		],
	},
	plugins: [new VueLoaderPlugin()],
};
