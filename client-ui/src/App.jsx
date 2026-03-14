import "./assets/bootstrap.min.css";
import "bootstrap/dist/js/bootstrap.bundle.min.js";
import "./App.css";
import { BrowserRouter, Route, Routes } from "react-router";
import Navbar from "./components/Navbar";
import Decks from "./components/Decks";
import { useState } from "react";

function App() {
    return (
        <div className="App">
            <BrowserRouter>
                <Navbar />
				<Routes>
					<Route path="/decks" element={<Decks />} />
				</Routes>
            </BrowserRouter>
        </div>
    );
}

export default App;
