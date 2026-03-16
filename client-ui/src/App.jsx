import "./assets/bootstrap.min.css";
import "bootstrap/dist/js/bootstrap.bundle.min.js";
import "./App.css";
import { BrowserRouter, Route, Routes } from "react-router";
import Navbar from "./components/Navbar";
import Decks from "./pages/Decks";
import NewDeck from "./pages/NewDeck";
import EditDeck from "./pages/EditDeck";

function App() {
    return (
        <>
            <BrowserRouter>
                <Navbar/>
				<Routes>
					<Route path="/" element={<Decks />} />
					<Route path="/new-deck" element={<NewDeck />} />
					<Route path="/edit-deck/:deckId" element={<EditDeck />} />
				</Routes>
            </BrowserRouter>
		</>
    );
}

export default App;
