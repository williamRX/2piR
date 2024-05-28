import { Box } from "@mui/material"
import HomeProduct from "./HomeProduct"
import HomeCategory from "./HomeCategory"
import ProductsList from "./ProductsList";

function HomePage() {

  return (
    <Box sx={{width:"80vw",margin:'0 auto', marginBottom:3}}>
        <HomeProduct />
        <HomeCategory />
        <ProductsList />
    </Box>
  )
}
export default HomePage